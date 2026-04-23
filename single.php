<?php
/**
 * Single post
 */

defined( 'ABSPATH' ) || exit;

get_header();

$container = function_exists( 'inlife_container_class' )
	? inlife_container_class()
	: 'container';

$post_id = get_the_ID();

$title = get_the_title( $post_id );
$date  = get_the_date( '', $post_id );

$format_badge = function_exists( 'inlife_get_society_format_badge' )
	? inlife_get_society_format_badge( $post_id )
	: '';

$format_terms = get_the_terms( $post_id, 'society_format' );
$format_slug  = ( ! empty( $format_terms ) && ! is_wp_error( $format_terms ) )
	? $format_terms[0]->slug
	: '';

$is_society = ! empty( $format_terms ) && ! is_wp_error( $format_terms );

$primary_category = function_exists( 'inlife_get_primary_post_category' )
	? inlife_get_primary_post_category( $post_id )
	: null;

$hero_image_id = has_post_thumbnail( $post_id ) ? get_post_thumbnail_id( $post_id ) : 0;

/**
 * Audio materials should not use the default photo-like cut corner treatment.
 */
$hero_variant     = ( 'posluchaj' === $format_slug ) ? 'audio' : '';
$hero_media_shape = ( 'posluchaj' === $format_slug ) ? '' : 'cut-tl';

if ( function_exists( 'get_field' ) ) {
	$hero_override = get_field( 'post_hero_image_override', $post_id );

	if ( is_array( $hero_override ) && ! empty( $hero_override['ID'] ) ) {
		$hero_image_id = (int) $hero_override['ID'];
	} elseif ( is_numeric( $hero_override ) ) {
		$hero_image_id = (int) $hero_override;
	}
}

$feature_media_html = function_exists( 'inlife_get_post_feature_media_html' )
	? inlife_get_post_feature_media_html( $post_id )
	: '';

$listing_url = function_exists( 'inlife_get_posts_listing_url_for_context' )
	? inlife_get_posts_listing_url_for_context()
	: home_url( '/' );

$entry_context = function_exists( 'inlife_get_entry_context' )
	? inlife_get_entry_context()
	: '';

$category_ids         = wp_get_post_categories( $post_id );
$default_category_id  = (int) get_option( 'default_category' );
$valid_category_ids   = [];
$related              = null;

if ( ! empty( $category_ids ) ) {
	foreach ( $category_ids as $category_id ) {
		if ( (int) $category_id === $default_category_id ) {
			continue;
		}

		$valid_category_ids[] = (int) $category_id;
	}
}

/**
 * Build related posts query with layered logic:
 *
 * Standard post:
 * 1. same category
 * 2. fallback to latest posts
 *
 * Society post:
 * 1. same society_format + same category (if category exists)
 * 2. fallback to same society_format
 * 3. fallback to latest posts
 */
if ( $is_society ) {
	$format_term_ids = wp_list_pluck( $format_terms, 'term_id' );

	// 1. Society: same format + same category.
	if ( ! empty( $format_term_ids ) && ! empty( $valid_category_ids ) ) {
		$related = new WP_Query(
			[
				'post_type'      => 'post',
				'posts_per_page' => 3,
				'post__not_in'   => [ $post_id ],
				'post_status'    => 'publish',
				'no_found_rows'  => true,
				'orderby'        => 'date',
				'order'          => 'DESC',
				'category__in'   => $valid_category_ids,
				'tax_query'      => [
					[
						'taxonomy' => 'society_format',
						'field'    => 'term_id',
						'terms'    => $format_term_ids,
					],
				],
			]
		);
	}

	// 2. Society fallback: same format only.
	if ( ! $related instanceof WP_Query || ! $related->have_posts() ) {
		$related = new WP_Query(
			[
				'post_type'      => 'post',
				'posts_per_page' => 3,
				'post__not_in'   => [ $post_id ],
				'post_status'    => 'publish',
				'no_found_rows'  => true,
				'orderby'        => 'date',
				'order'          => 'DESC',
				'tax_query'      => [
					[
						'taxonomy' => 'society_format',
						'field'    => 'term_id',
						'terms'    => $format_term_ids,
					],
				],
			]
		);
	}
} else {
	// 1. Standard news: same category.
	if ( ! empty( $valid_category_ids ) ) {
		$related = new WP_Query(
			[
				'post_type'      => 'post',
				'posts_per_page' => 3,
				'post__not_in'   => [ $post_id ],
				'post_status'    => 'publish',
				'no_found_rows'  => true,
				'orderby'        => 'date',
				'order'          => 'DESC',
				'category__in'   => $valid_category_ids,
				'meta_query'     => [
					[
						'key'     => 'show_in_main_news_archive',
						'value'   => '1',
						'compare' => '=',
					],
				],
			]
		);
	}
}

// 3. Final fallback: latest posts.
if ( ! $related instanceof WP_Query || ! $related->have_posts() ) {
	$related = new WP_Query(
		[
			'post_type'      => 'post',
			'posts_per_page' => 3,
			'post__not_in'   => [ $post_id ],
			'post_status'    => 'publish',
			'no_found_rows'  => true,
			'orderby'        => 'date',
			'order'          => 'DESC',
		]
	);
}

if ( 'society' === $entry_context ) {
	$latest_news = new WP_Query(
		[
			'post_type'      => 'post',
			'posts_per_page' => 4,
			'post__not_in'   => [ $post_id ],
			'post_status'    => 'publish',
			'no_found_rows'  => true,
			'orderby'        => 'date',
			'order'          => 'DESC',
			'tax_query'      => [
				[
					'taxonomy' => 'society_format',
					'field'    => 'slug',
					'operator' => 'EXISTS',
				],
			],
		]
	);
} else {
	$latest_news = new WP_Query(
		[
			'post_type'      => 'post',
			'posts_per_page' => 4,
			'post__not_in'   => [ $post_id ],
			'post_status'    => 'publish',
			'no_found_rows'  => true,
			'orderby'        => 'date',
			'order'          => 'DESC',
			'meta_query'     => [
				[
					'key'     => 'show_in_main_news_archive',
					'value'   => '1',
					'compare' => '=',
				],
			],
		]
	);
}
?>

<main id="main-content" class="site-main site-main--single-post">

	<section class="page-section page-section--post-hero">
		<?php
		ob_start();
		?>
		<div class="post-hero__meta">
			<?php if ( $date ) : ?>
				<span class="post-hero__date"><?php echo esc_html( $date ); ?></span>
			<?php endif; ?>

			<?php if ( $format_badge ) : ?>
				<span class="post-hero__format-badge"><?php echo esc_html( $format_badge ); ?></span>
			<?php endif; ?>

			<?php if ( $primary_category ) : ?>
				<span class="post-hero__category-badge"><?php echo esc_html( $primary_category->name ); ?></span>
			<?php endif; ?>
		</div>
		<?php
		$before_lead = trim( (string) ob_get_clean() );

		get_template_part(
			'template-parts/patterns/pattern-media-hero',
			null,
			[
				'kicker'                 => inlife_t( 'Aktualności' ),
				'title'                  => $title,
				'lead'                   => '',
				'breadcrumbs'            => true,
				'breadcrumbs_full_width' => true,
				'before_lead'            => $before_lead,
				'image_id'               => $hero_image_id,
				'media_shape'            => $hero_media_shape,
				'variant'                => $hero_variant,
			]
		);
		?>
	</section>

	<section class="page-section page-section--post-layout">
		<div class="<?php echo esc_attr( $container ); ?>">

			<div class="post-layout">

				<div class="post-layout__main">
					<article class="post-content">
						<div class="post-content__body">
							<div class="post-content__entry entry-content">
								<?php if ( $feature_media_html ) : ?>
									<div class="post-content__media">
										<?php echo $feature_media_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
									</div>
								<?php endif; ?>

								<?php
								while ( have_posts() ) :
									the_post();
									the_content();
								endwhile;
								?>
							</div>

							<div class="post-content__footer">
								<?php $share = inlife_get_share_links(); ?>

								<div class="post-share">
									<span class="post-share__label"><?php echo esc_html( inlife_t( 'Udostępnij:' ) ); ?></span>

									<div class="post-share__list">

										<button
											class="post-share__item js-copy-link"
											data-url="<?php echo esc_url( $share['copy'] ); ?>"
											aria-label="<?php esc_attr_e( 'Kopiuj link', 'inlife' ); ?>"
										>
											<span class="bi bi-link-45deg"></span>
										</button>

										<a
											class="post-share__item"
											href="<?php echo esc_url( $share['facebook'] ); ?>"
											target="_blank"
											rel="noopener"
										>
											<span class="bi bi-facebook"></span>
										</a>

										<a
											class="post-share__item"
											href="<?php echo esc_url( $share['linkedin'] ); ?>"
											target="_blank"
											rel="noopener"
										>
											<span class="bi bi-linkedin"></span>
										</a>

										<a
											class="post-share__item"
											href="<?php echo esc_url( $share['mail'] ); ?>"
										>
											<span class="bi bi-envelope"></span>
										</a>

									</div>
								</div>
							</div>
						</div>
					</article>
				</div>

				<?php if ( $related->have_posts() ) : ?>
					<aside class="post-layout__aside" aria-labelledby="related-posts-heading">
						<div class="post-related">

							<h2 id="related-posts-heading" class="post-related__title">
								<?php echo esc_html( $is_society ? inlife_t( 'Powiązane materiały' ) : inlife_t( 'Powiązane artykuły' ) ); ?>
							</h2>

							<div class="post-related__list">
								<?php while ( $related->have_posts() ) : $related->the_post(); ?>
									<?php
									$related_id           = get_the_ID();
									$related_date         = get_the_date( '', $related_id );
									$related_format_badge = function_exists( 'inlife_get_society_format_badge' )
										? inlife_get_society_format_badge( $related_id )
										: '';
									$related_category     = function_exists( 'inlife_get_primary_post_category' )
										? inlife_get_primary_post_category( $related_id )
										: null;
									?>
									<article class="post-related-item">
										<div class="post-related-item__meta">
											<?php if ( $related_format_badge ) : ?>
												<span class="post-related-item__format">
													<?php echo esc_html( $related_format_badge ); ?>
												</span>
											<?php endif; ?>

											<?php if ( $related_date ) : ?>
												<span class="post-related-item__date">
													<?php echo esc_html( $related_date ); ?>
												</span>
											<?php endif; ?>

											<?php if ( ! $related_format_badge && $related_category ) : ?>
												<span class="post-related-item__category">
													<?php echo esc_html( $related_category->name ); ?>
												</span>
											<?php endif; ?>
										</div>

										<h3 class="post-related-item__title">
											<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
										</h3>
									</article>
								<?php endwhile; ?>
							</div>

							<div class="post-related__footer">
								<a class="c-readmore" href="<?php echo esc_url( $listing_url ); ?>">
									<?php echo esc_html( 'society' === $entry_context ? inlife_t( 'Zobacz wszystkie materiały' ) : inlife_t( 'Zobacz wszystkie aktualności' ) ); ?>
									<span class="c-readmore__icon" aria-hidden="true">→</span>
								</a>
							</div>

						</div>
					</aside>
				<?php endif; ?>

			</div>

		</div>
	</section>

	<?php if ( $latest_news->have_posts() ) : ?>
		<section class="page-section page-section--post-latest">
			<div class="<?php echo esc_attr( $container ); ?>">
				<div class="post-latest">

					<div class="post-latest__header">
						<h2 class="post-latest__title">
							<?php
							echo esc_html(
								'society' === $entry_context
									? inlife_t( 'Ostatnio dodane materiały' )
									: inlife_t( 'Ostatnio dodane aktualności' )
							);
							?>
						</h2>

						<a class="c-readmore" href="<?php echo esc_url( $listing_url ); ?>">
							<?php echo esc_html( 'society' === $entry_context ? inlife_t( 'Zobacz wszystkie materiały' ) : inlife_t( 'Zobacz wszystkie' ) ); ?>
							<span class="c-readmore__icon" aria-hidden="true">→</span>
						</a>
					</div>

					<div class="post-latest__grid">
						<?php while ( $latest_news->have_posts() ) : $latest_news->the_post(); ?>
							<div class="post-latest__item">
								<p class="post-latest__date"><?php echo esc_html( get_the_date() ); ?></p>
								<h3 class="post-latest__item-title">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</h3>
							</div>
						<?php endwhile; ?>
					</div>

				</div>
			</div>
		</section>
	<?php endif; ?>

</main>

<?php
wp_reset_postdata();
get_footer();
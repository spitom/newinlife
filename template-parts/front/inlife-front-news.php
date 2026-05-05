<?php
defined( 'ABSPATH' ) || exit;

$container = function_exists( 'inlife_container_class' ) ? inlife_container_class() : 'container';

$query = new WP_Query(
	[
		'post_type'      => 'post',
		'posts_per_page' => 4,
		'post_status'    => 'publish',
		'no_found_rows'  => true,
		'meta_query'     => [
			[
				'key'     => 'show_on_front_news',
				'value'   => '1',
				'compare' => '=',
			],
		],
	]
);

if ( ! $query->have_posts() ) {
	return;
}

$posts_page_id = (int) get_option( 'page_for_posts' );
$posts_url     = $posts_page_id ? get_permalink( $posts_page_id ) : get_post_type_archive_link( 'post' );

$posts = $query->posts;
$main  = array_shift( $posts );
?>

<section class="page-section page-section--front-news" aria-labelledby="front-news-heading">
	<div class="<?php echo esc_attr( $container ); ?>">

		<div class="front-news-editorial">

			<div class="front-news-editorial__intro">
				<p class="front-news-editorial__kicker">
					<?php echo esc_html( inlife_t( 'Aktualności' ) ); ?>
				</p>

				<h2 id="front-news-heading" class="front-news-editorial__title">
					<?php echo esc_html( inlife_t( 'Najnowsze informacje z życia InLife' ) ); ?>
				</h2>

				<p class="front-news-editorial__lead">
					<?php echo esc_html( inlife_t( 'Wiadomości, wydarzenia, projekty i inicjatywy realizowane przez InLife.' ) ); ?>
				</p>

				<?php if ( $posts_url ) : ?>
					<a class="c-readmore front-news-editorial__readmore" href="<?php echo esc_url( $posts_url ); ?>">
						<?php echo esc_html( inlife_t( 'Zobacz wszystkie aktualności' ) ); ?>
						<span class="c-readmore__icon" aria-hidden="true">→</span>
					</a>
				<?php endif; ?>
			</div>

			<div class="front-news-editorial__content">

				<?php if ( $main instanceof WP_Post ) : ?>
					<?php
					$main_id       = $main->ID;
					$main_url      = get_permalink( $main_id );
					$main_title    = get_the_title( $main_id );
					$main_date     = get_the_date( '', $main_id );
					$main_image_id = function_exists( 'inlife_get_post_card_image_id' )
						? inlife_get_post_card_image_id( $main_id )
						: get_post_thumbnail_id( $main_id );

					$main_category = function_exists( 'inlife_get_primary_post_category' )
						? inlife_get_primary_post_category( $main_id )
						: null;
					?>

					<a class="front-news-feature" href="<?php echo esc_url( $main_url ); ?>">
						<div class="front-news-feature__media">
							<?php if ( $main_image_id ) : ?>
								<?php
								echo wp_get_attachment_image(
									$main_image_id,
									'large',
									false,
									[
										'class'   => 'front-news-feature__image',
										'loading' => 'lazy',
										'alt'     => '',
									]
								);
								?>
							<?php else : ?>
								<div class="front-news-feature__placeholder">
									<span><?php echo esc_html( inlife_t( 'Aktualność' ) ); ?></span>
								</div>
							<?php endif; ?>
						</div>

						<div class="front-news-feature__body">
							<div class="front-news-feature__meta">
								<?php if ( $main_category ) : ?>
									<span><?php echo esc_html( $main_category->name ); ?></span>
								<?php endif; ?>

								<?php if ( $main_date ) : ?>
									<time datetime="<?php echo esc_attr( get_the_date( 'c', $main_id ) ); ?>">
										<?php echo esc_html( $main_date ); ?>
									</time>
								<?php endif; ?>
							</div>

							<h3 class="front-news-feature__title">
								<?php echo esc_html( $main_title ); ?>
							</h3>

							<span class="front-news-feature__arrow" aria-hidden="true">→</span>
						</div>
					</a>
				<?php endif; ?>

				<?php if ( ! empty( $posts ) ) : ?>
					<div class="front-news-list" aria-label="<?php echo esc_attr( inlife_t( 'Pozostałe aktualności' ) ); ?>">
						<?php foreach ( $posts as $post_item ) : ?>
							<?php
							$item_id    = $post_item->ID;
							$item_url   = get_permalink( $item_id );
							$item_title = get_the_title( $item_id );
							$item_date  = get_the_date( '', $item_id );

							$item_category = function_exists( 'inlife_get_primary_post_category' )
								? inlife_get_primary_post_category( $item_id )
								: null;
							?>

							<a class="front-news-row" href="<?php echo esc_url( $item_url ); ?>">
								<div class="front-news-row__meta">
									<?php if ( $item_category ) : ?>
										<span><?php echo esc_html( $item_category->name ); ?></span>
									<?php endif; ?>

									<?php if ( $item_date ) : ?>
										<time datetime="<?php echo esc_attr( get_the_date( 'c', $item_id ) ); ?>">
											<?php echo esc_html( $item_date ); ?>
										</time>
									<?php endif; ?>
								</div>

								<h3 class="front-news-row__title">
									<?php echo esc_html( $item_title ); ?>
								</h3>

								<span class="front-news-row__arrow" aria-hidden="true">→</span>
							</a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

			</div>

		</div>

	</div>
</section>

<?php wp_reset_postdata(); ?>
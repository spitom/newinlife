<?php
/**
 * Popielno — News.
 *
 * @package newinlife-child
 */

defined( 'ABSPATH' ) || exit;

$category = function_exists( 'inlife_get_research_station_category' )
	? inlife_get_research_station_category()
	: null;

if ( ! $category instanceof WP_Term ) {
	return;
}

$query_args = [
	'post_type'        => 'post',
	'post_status'      => 'publish',
	'posts_per_page'   => 5,
	'orderby'          => 'date',
	'order'            => 'DESC',
	'no_found_rows'    => true,
	'suppress_filters' => false,
	'category__in'     => [ (int) $category->term_id ],
];

if ( function_exists( 'pll_current_language' ) ) {
	$current_language = (string) pll_current_language( 'slug' );

	if ( '' !== $current_language ) {
		$query_args['lang'] = $current_language;
	}
}

$query = new WP_Query( $query_args );

if ( ! $query->have_posts() ) {
	return;
}

$category_url = get_term_link( $category );

$all_news_url = ! is_wp_error( $category_url )
	? $category_url
	: '';

$section_action = '';

if ( $all_news_url ) {
	ob_start();
	?>
	<a
		class="c-readmore"
		href="<?php echo esc_url( $all_news_url ); ?>"
	>
		<?php echo esc_html( inlife_t( 'Zobacz wszystkie aktualności' ) ); ?>
		<span class="c-readmore__icon" aria-hidden="true">→</span>
	</a>
	<?php
	$section_action = trim( (string) ob_get_clean() );
}
?>

<section
	id="aktualnosci"
	class="page-section popielno-news"
	aria-labelledby="popielno-news-heading"
>
	<div class="<?php echo esc_attr( inlife_container_class( 'content' ) ); ?>">

		<?php
		get_template_part(
			'template-parts/components/section-header',
			null,
			[
				'kicker'      => inlife_t( 'Aktualności' ),
				'title'       => inlife_t( 'Najnowsze informacje ze Stacji' ),
				'title_id'    => 'popielno-news-heading',
                'action_html' => $section_action,
			]
		);
		?>

		<ul class="popielno-news__list">
			<?php while ( $query->have_posts() ) : ?>
				<?php
				$query->the_post();

				$post_title = get_the_title();
				$post_url   = get_permalink();
				?>
				<li class="popielno-news__item">
					<a
						class="popielno-news__link"
						href="<?php echo esc_url( $post_url ); ?>"
					>
						<time
							class="popielno-news__date"
							datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"
						>
							<?php echo esc_html( get_the_date( 'Y-m-d' ) ); ?>
						</time>

						<span class="popielno-news__title">
							<?php echo esc_html( $post_title ); ?>
						</span>

						<span class="popielno-news__arrow" aria-hidden="true">
							→
						</span>
					</a>
				</li>
			<?php endwhile; ?>
		</ul>

		<?php wp_reset_postdata(); ?>

	</div>
</section>

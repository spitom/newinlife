<?php
defined( 'ABSPATH' ) || exit;

$container = function_exists( 'inlife_container_class' )
	? inlife_container_class()
	: 'container';

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
?>

<section class="page-section page-section--front-news">
	<div class="<?php echo esc_attr( $container ); ?>">

		<?php
		get_template_part(
			'template-parts/components/section-header',
			null,
			[
				'kicker' => inlife_t( 'Aktualności' ),
				'title'  => inlife_t( 'Aktualności' ),
				'lead'   => '',
			]
		);
		?>

		<div class="front-news__grid c-card-grid">
			<?php while ( $query->have_posts() ) : $query->the_post(); ?>
				<div class="front-news__item">
					<?php
					get_template_part(
						'template-parts/posts/posts',
						'card',
						[
							'post_id' => get_the_ID(),
						]
					);
					?>
				</div>
			<?php endwhile; ?>
		</div>

		<?php
		$posts_page_id = (int) get_option( 'page_for_posts' );

		if ( $posts_page_id ) :
		?>
			<div class="front-news__footer">
				<a
					class="btn btn-outline-primary"
					href="<?php echo esc_url( get_permalink( $posts_page_id ) ); ?>"
				>
					<?php echo esc_html( inlife_t( 'Zobacz wszystkie aktualności' ) ); ?>
				</a>
			</div>
		<?php endif; ?>

	</div>
</section>

<?php wp_reset_postdata(); ?>
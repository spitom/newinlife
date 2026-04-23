<?php
/**
 * Posts archive filters
 */

defined( 'ABSPATH' ) || exit;

$container = $args['container'] ?? ( function_exists( 'inlife_container_class' ) ? inlife_container_class() : 'container' );

$terms = function_exists( 'inlife_get_news_filter_categories' )
	? inlife_get_news_filter_categories()
	: [];

if ( empty( $terms ) ) {
	return;
}

$current_category = isset( $_GET['news_category'] )
	? sanitize_title( wp_unslash( $_GET['news_category'] ) )
	: '';

$posts_page_url = get_permalink( get_option( 'page_for_posts' ) );

if ( ! $posts_page_url ) {
	$posts_page_url = home_url( '/' );
}
?>

<section class="page-section page-section--posts-filters">
	<div class="<?php echo esc_attr( $container ); ?>">
		<nav class="posts-filters" aria-label="<?php echo esc_attr( inlife_t( 'Filtry aktualności' ) ); ?>">
			<ul class="posts-filters__list" role="list">
				<li class="posts-filters__item">
					<a
						class="posts-filters__link<?php echo '' === $current_category ? ' is-active' : ''; ?>"
						href="<?php echo esc_url( $posts_page_url ); ?>"
					>
						<?php echo esc_html( inlife_t( 'Wszystkie' ) ); ?>
					</a>
				</li>

				<?php foreach ( $terms as $term ) : ?>
					<li class="posts-filters__item">
						<a
							class="posts-filters__link<?php echo $current_category === $term->slug ? ' is-active' : ''; ?>"
							href="<?php echo esc_url( add_query_arg( 'news_category', $term->slug, $posts_page_url ) ); ?>"
						>
							<?php echo esc_html( $term->name ); ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</nav>
	</div>
</section>
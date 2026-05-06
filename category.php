<?php
/**
 * Category archive
 */

defined( 'ABSPATH' ) || exit;

get_header();

$container = function_exists( 'inlife_container_class' )
	? inlife_container_class()
	: 'container';

$term = get_queried_object();
?>

<main id="main-content" class="site-main site-main--posts site-main--term-archive">

	<section class="page-section page-section--posts-hero">
		<?php
		get_template_part(
			'template-parts/patterns/pattern-page-hero',
			null,
			[
				'kicker'      => inlife_t( 'Aktualności' ),
				'title'       => single_cat_title( '', false ),
				'lead'        => category_description() ? wp_strip_all_tags( category_description() ) : inlife_t( 'Wpisy przypisane do wybranej kategorii.' ),
				'breadcrumbs' => true,
			]
		);
		?>
	</section>

	<section class="page-section page-section--posts-archive">
		<?php
		get_template_part(
			'template-parts/posts/posts',
			'archive-grid',
			[
				'container' => $container,
			]
		);
		?>
	</section>

</main>

<?php
get_footer();
<?php
/**
 * Posts archive (Aktualności)
 */

defined( 'ABSPATH' ) || exit;

get_header();

$container = function_exists( 'inlife_container_class' )
	? inlife_container_class()
	: 'container';
?>

<main id="main-content" class="site-main site-main--posts">

	<section class="page-section page-section--posts-hero">
		<?php
		get_template_part(
			'template-parts/patterns/pattern-page-hero',
			null,
			[
				'kicker'      => inlife_t( 'Aktualności' ),
				'title'       => inlife_t( 'Aktualności' ),
				'lead'        => inlife_t( 'Bieżące informacje, artykuły i materiały dotyczące działalności Instytutu.' ),
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
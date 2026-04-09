<?php
/**
 * Archive template for Laboratories
 *
 * @package newinlife
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="main-content" class="site-main site-main--laboratories">

	<section class="page-section page-section--laboratories-hero">
		<?php
		get_template_part(
			'template-parts/patterns/pattern-page-hero',
			null,
			[
				'kicker'      => inlife_t( 'Badania' ),
				'title'       => inlife_t( 'Laboratoria' ),
				'lead'        => inlife_t( 'Poznaj laboratoria wspierające działalność badawczą instytutu, oferujące specjalistyczne metody, analizy oraz zaplecze aparaturowe.' ),
				'breadcrumbs' => true,
			]
		);
		?>
	</section>
	<?php get_template_part( 'template-parts/laboratories/laboratories-archive', 'grid' ); ?>

</main>

<?php
get_footer();
<?php
/**
 * Template Name: Badania – Overview
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

get_header();

$container = function_exists( 'inlife_container_class' ) ? inlife_container_class() : 'container';
?>

<main id="main-content" class="site-main site-main--landing site-main--research-overview">

	<section class="page-section page-section--research-hero">
		<?php
		get_template_part(
			'template-parts/patterns/pattern-page-hero',
			null,
			[
				'kicker'      => inlife_t( 'Badania' ),
				'title'       => get_the_title(),
				'lead'        => inlife_t( 'Poznaj główne obszary działalności naukowej Instytutu: zespoły badawcze, laboratoria, projekty, publikacje oraz pozostałe zasoby wspierające rozwój badań.' ),
				'breadcrumbs' => true,
			]
		);
		?>
	</section>

	<section class="page-section page-section--research-nav">
		<div class="<?php echo esc_attr( $container ); ?>">
			<?php
			get_template_part(
				'template-parts/research/research',
				'navigation-grid',
				[
					'section_id' => 'research-navigation',
					'title_id'   => 'research-navigation-heading',
				]
			);
			?>
		</div>
	</section>

</main>

<?php
get_footer();
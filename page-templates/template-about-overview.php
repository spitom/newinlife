<?php
/**
 * Template Name: O nas – Overview
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

get_header();

$container = function_exists( 'inlife_container_class' ) ? inlife_container_class() : 'container';
?>

<main id="main-content" class="site-main site-main--landing site-main--about">

	<section class="page-section page-section--about-hero">
		<?php
		get_template_part(
			'template-parts/patterns/pattern-page-hero',
			null,
			[
				'kicker'      => inlife_t( 'O nas' ),
				'title'       => get_the_title(),
				'lead'        => inlife_t( 'Poznaj Instytut, jego misję, strukturę, historię oraz najważniejsze informacje wspierające zrozumienie naszej działalności naukowej i organizacyjnej.' ),
				'breadcrumbs' => true,
			]
		);
		?>
	</section>

	<section class="page-section page-section--intro">
		<div class="<?php echo esc_attr( $container ); ?>">
			<?php get_template_part( 'template-parts/page/page', 'intro' ); ?>
		</div>
	</section>

	<section class="page-section page-section--about-mission" aria-labelledby="about-mission-heading">
		<div class="<?php echo esc_attr( $container ); ?>">
			<?php get_template_part( 'template-parts/about/about', 'mission' ); ?>
		</div>
	</section>

	<section class="page-section page-section--about-directorate" aria-labelledby="about-directorate-heading">
		<div class="<?php echo esc_attr( $container ); ?>">
			<?php get_template_part( 'template-parts/about/about', 'directorate' ); ?>
		</div>
	</section>

	<section class="page-section page-section--about-structure" aria-labelledby="about-structure-heading">
		<div class="<?php echo esc_attr( $container ); ?>">
			<?php get_template_part( 'template-parts/about/about', 'structure-teaser' ); ?>
		</div>
	</section>

	<section class="page-section page-section--about-history" aria-labelledby="about-history-heading">
		<div class="<?php echo esc_attr( $container ); ?>">
			<?php get_template_part( 'template-parts/about/about', 'history-teaser' ); ?>
		</div>
	</section>

	<section class="page-section page-section--about-media" aria-labelledby="about-media-heading">
		<div class="<?php echo esc_attr( $container ); ?>">
			<?php get_template_part( 'template-parts/about/about', 'media-teaser' ); ?>
		</div>
	</section>

	<section class="page-section page-section--cta">
		<div class="<?php echo esc_attr( $container ); ?>">
			<?php get_template_part( 'template-parts/page/page', 'cta' ); ?>
		</div>
	</section>

</main>

<?php
get_footer();
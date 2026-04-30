<?php
/**
 * Template Name: O nas – Overview
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

get_header();

$container = function_exists( 'inlife_container_class' ) ? inlife_container_class() : 'container';

$post_id = get_the_ID();

/**
 * HERO
 */
$hero_kicker = inlife_get_acf_field(
	'about_hero_kicker',
	$post_id,
	inlife_t( 'O nas' )
);

$hero_title = inlife_get_acf_field(
	'about_hero_title',
	$post_id,
	get_the_title()
);

$hero_lead = inlife_get_acf_field(
	'about_hero_lead',
	$post_id,
	inlife_t( 'Poznaj Instytut, jego misję, strukturę, historię oraz najważniejsze informacje wspierające zrozumienie naszej działalności naukowej i organizacyjnej.' )
);
?>

<main id="main-content" class="site-main site-main--landing site-main--about">

	<!-- HERO -->
	<section class="page-section page-section--about-hero">
		<?php
		get_template_part(
			'template-parts/patterns/pattern-page-hero',
			null,
			[
				'kicker'      => $hero_kicker,
				'title'       => $hero_title,
				'lead'        => $hero_lead,
				'breadcrumbs' => true,
				'title_id'    => 'about-hero-heading',
			]
		);
		?>
	</section>

	<!-- INTRO / MISJA -->
	<section class="page-section page-section--about-intro" aria-labelledby="about-intro-heading">
		<div class="<?php echo esc_attr( $container ); ?>">
			<?php get_template_part( 'template-parts/about/about', 'intro' ); ?>
		</div>
	</section>

	<!-- DYREKCJA -->
	<section class="page-section page-section--about-directorate" aria-labelledby="about-directorate-heading">
		<div class="<?php echo esc_attr( $container ); ?>">
			<?php get_template_part( 'template-parts/about/about', 'directorate' ); ?>
		</div>
	</section>

	<section class="page-section page-section--about-structure" aria-labelledby="about-structure-heading">
		<div class="<?php echo esc_attr( $container ); ?>">
			<?php get_template_part( 'template-parts/about/about', 'structure' ); ?>
		</div>
	</section>

	<!-- HISTORIA -->
	<section class="page-section page-section--about-history" aria-labelledby="about-history-heading">
		<div class="<?php echo esc_attr( $container ); ?>">
			<?php get_template_part( 'template-parts/about/about', 'history' ); ?>
		</div>
	</section>

	<!-- DLA MEDIÓW -->
	<section class="page-section page-section--about-media" aria-labelledby="about-media-heading">
		<div class="<?php echo esc_attr( $container ); ?>">
			<?php get_template_part( 'template-parts/about/about', 'media' ); ?>
		</div>
	</section>

</main>

<?php
get_footer();
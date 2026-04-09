<?php
/**
 * Template Name: Kariera – Konkursy i oferty
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

get_header();

$container = function_exists( 'inlife_container_class' ) ? inlife_container_class() : 'container';
?>

<main id="main-content" class="site-main site-main--career-opportunities">

	<section class="page-section page-section--career-opportunities-hero" aria-labelledby="career-opportunities-heading">
		<?php
		get_template_part(
			'template-parts/patterns/pattern-page-hero',
			null,
			[
				'kicker'      => inlife_t( 'Kariera' ),
				'title'       => inlife_t( 'Oferty pracy, konkursy i dokumenty' ),
				'lead'        => inlife_t( 'W tej sekcji znajdują się aktualne konkursy na stanowiska naukowe, ogłoszenia o pracę, wyniki naborów, materiały archiwalne, dokumenty oraz informacje wspierające mobilność zawodową.' ),
				'breadcrumbs' => true,
			]
		);
		?>
	</section>

	<section class="page-section page-section--career-opportunities-nav" aria-label="<?php echo esc_attr( inlife_t( 'Nawigacja sekcji ofert i konkursów' ) ); ?>">
		<div class="<?php echo esc_attr( $container ); ?>">
			<?php get_template_part( 'template-parts/career/career-opportunities', 'nav' ); ?>
		</div>
	</section>

	<section class="page-section page-section--career-opportunities-scientific" id="konkursy-naukowe" aria-labelledby="career-scientific-heading">
		<div class="<?php echo esc_attr( $container ); ?>">
			<?php get_template_part( 'template-parts/career/career-opportunities', 'scientific' ); ?>
		</div>
	</section>

	<section class="page-section page-section--career-opportunities-jobs" id="ogloszenia-o-prace" aria-labelledby="career-jobs-heading">
		<div class="<?php echo esc_attr( $container ); ?>">
			<?php get_template_part( 'template-parts/career/career-opportunities', 'jobs' ); ?>
		</div>
	</section>

	<section class="page-section page-section--career-opportunities-results" id="wyniki-konkursow" aria-labelledby="career-results-heading">
		<div class="<?php echo esc_attr( $container ); ?>">
			<?php get_template_part( 'template-parts/career/career-opportunities', 'results' ); ?>
		</div>
	</section>

	<section class="page-section page-section--career-opportunities-archive" id="ogloszenia-archiwalne" aria-labelledby="career-archive-heading">
		<div class="<?php echo esc_attr( $container ); ?>">
			<?php get_template_part( 'template-parts/career/career-opportunities', 'archive' ); ?>
		</div>
	</section>

	<section class="page-section page-section--career-opportunities-mobility" id="mobilnosc" aria-labelledby="career-mobility-heading">
		<div class="<?php echo esc_attr( $container ); ?>">
			<?php get_template_part( 'template-parts/career/career-opportunities', 'mobility' ); ?>
		</div>
	</section>

</main>

<?php
get_footer();
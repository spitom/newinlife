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
				'lead'        => inlife_t( 'W tej sekcji znajdują się aktualne konkursy na stanowiska naukowe, ogłoszenia o pracę, wyniki naborów, materiały archiwalne oraz informacje wspierające mobilność zawodową.' ),
				'breadcrumbs' => true,
			]
		);
		?>
	</section>

	<section class="page-section page-section--career-opportunities-current" id="aktualne-oferty" aria-labelledby="career-current-heading">
		<div class="<?php echo esc_attr( $container ); ?>">
			<?php get_template_part( 'template-parts/career/career-opportunities', 'current' ); ?>
		</div>
	</section>

	<section class="page-section page-section--career-opportunities-secondary" aria-labelledby="career-secondary-heading">
		<div class="<?php echo esc_attr( $container ); ?>">
			<?php get_template_part( 'template-parts/career/career-opportunities', 'secondary' ); ?>
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
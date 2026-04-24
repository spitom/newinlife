<?php
/**
 * Career doctoral school teaser
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

$section_kicker = function_exists( 'get_field' ) ? get_field( 'career_doctoral_school_kicker', $post_id ) : '';
$section_title  = function_exists( 'get_field' ) ? get_field( 'career_doctoral_school_title', $post_id ) : '';
$section_text   = function_exists( 'get_field' ) ? get_field( 'career_doctoral_school_text', $post_id ) : '';
$cta_label      = function_exists( 'get_field' ) ? get_field( 'career_doctoral_school_cta_label', $post_id ) : '';
$cta_url        = function_exists( 'get_field' ) ? get_field( 'career_doctoral_school_cta_url', $post_id ) : '';

$section_kicker = $section_kicker ?: inlife_t( 'Rozwój naukowy' );
$section_title  = $section_title ?: inlife_t( 'Szkoła Doktorska' );
$section_text   = $section_text ?: inlife_t( 'Osoby zainteresowane rozwojem naukowym mogą kontynuować swoją ścieżkę w Szkole Doktorskiej prowadzonej przy Instytucie. To przestrzeń do pogłębiania kompetencji badawczych, pracy z zespołami naukowymi i realizacji ambitnych projektów.' );
$cta_label      = $cta_label ?: inlife_t( 'Przejdź do strony Szkoły Doktorskiej' );
$cta_url        = $cta_url ?: 'https://sd.pan.olsztyn.pl/';
?>

<div class="career-doctoral-school career-doctoral-school--featured">
	<div class="career-doctoral-school__content">
		<p class="career-doctoral-school__kicker">
			<?php echo esc_html( $section_kicker ); ?>
		</p>

		<h2 id="career-doctoral-school-heading" class="career-doctoral-school__title">
			<?php echo esc_html( $section_title ); ?>
		</h2>

		<?php if ( $section_text ) : ?>
			<p class="career-doctoral-school__text">
				<?php echo esc_html( $section_text ); ?>
			</p>
		<?php endif; ?>
	</div>

	<div class="career-doctoral-school__action">
		<a
			class="btn btn-outline-primary career-doctoral-school__button"
			href="<?php echo esc_url( $cta_url ); ?>"
			target="_blank"
			rel="noopener noreferrer"
		>
			<span><?php echo esc_html( $cta_label ); ?></span>
			<span class="career-doctoral-school__button-icon" aria-hidden="true">→</span>
		</a>
	</div>
</div>
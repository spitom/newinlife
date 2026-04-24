<?php
/**
 * Career opportunities - secondary entry points
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

$section_kicker = function_exists( 'get_field' ) ? get_field( 'career_opportunities_secondary_kicker', $post_id ) : '';
$section_title  = function_exists( 'get_field' ) ? get_field( 'career_opportunities_secondary_title', $post_id ) : '';
$section_text   = function_exists( 'get_field' ) ? get_field( 'career_opportunities_secondary_text', $post_id ) : '';

$results_text      = function_exists( 'get_field' ) ? get_field( 'career_opportunities_results_text', $post_id ) : '';
$results_cta_label = function_exists( 'get_field' ) ? get_field( 'career_opportunities_results_cta_label', $post_id ) : '';
$archive_text      = function_exists( 'get_field' ) ? get_field( 'career_opportunities_archive_text', $post_id ) : '';
$archive_cta_label = function_exists( 'get_field' ) ? get_field( 'career_opportunities_archive_cta_label', $post_id ) : '';

$section_kicker = $section_kicker ?: inlife_t( 'Informacje' );
$section_title  = $section_title ?: inlife_t( 'Wyniki i archiwum ogłoszeń' );
$section_text   = $section_text ?: inlife_t( 'Sprawdź wyniki zakończonych naborów oraz archiwalne ogłoszenia o pracę i konkursy na stanowiska naukowe.' );

$results_text      = $results_text ?: inlife_t( 'Zobacz wyniki zakończonych konkursów i procesów rekrutacyjnych.' );
$results_cta_label = $results_cta_label ?: inlife_t( 'Przejdź do wyników' );
$archive_text      = $archive_text ?: inlife_t( 'Przeglądaj archiwalne ogłoszenia o pracę i konkursy.' );
$archive_cta_label = $archive_cta_label ?: inlife_t( 'Zobacz archiwum' );

$results_url = function_exists( 'inlife_get_career_term_archive_url' )
	? inlife_get_career_term_archive_url( 'results' )
	: '#';

$archive_url = function_exists( 'inlife_get_career_term_archive_url' )
	? inlife_get_career_term_archive_url( 'archive' )
	: '#';

get_template_part(
	'template-parts/components/section-header',
	null,
	[
		'kicker'   => $section_kicker,
		'title'    => $section_title,
		'lead'     => $section_text,
		'title_id' => 'career-secondary-heading',
	]
);
?>

<div class="c-card-grid c-card-grid--2 career-opportunities-secondary-grid">

	<a class="c-surface c-surface--panel career-opportunities-entry-card" href="<?php echo esc_url( $results_url ); ?>">
		<h3 class="career-opportunities-entry-card__title">
			<?php echo esc_html( inlife_get_career_type_label( 'results' ) ); ?>
		</h3>

		<p class="career-opportunities-entry-card__text">
			<?php echo esc_html( $results_text ); ?>
		</p>

		<span class="c-readmore career-opportunities-entry-card__readmore">
			<span class="c-readmore__label"><?php echo esc_html( $results_cta_label ); ?></span>
			<span class="c-readmore__icon" aria-hidden="true">→</span>
		</span>
	</a>

	<a class="c-surface c-surface--panel career-opportunities-entry-card" href="<?php echo esc_url( $archive_url ); ?>">
		<h3 class="career-opportunities-entry-card__title">
			<?php echo esc_html( inlife_get_career_type_label( 'archive' ) ); ?>
		</h3>

		<p class="career-opportunities-entry-card__text">
			<?php echo esc_html( $archive_text ); ?>
		</p>

		<span class="c-readmore career-opportunities-entry-card__readmore">
			<span class="c-readmore__label"><?php echo esc_html( $archive_cta_label ); ?></span>
			<span class="c-readmore__icon" aria-hidden="true">→</span>
		</span>
	</a>

</div>
<?php
/**
 * Career opportunities - secondary entry points
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

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
		'kicker'   => inlife_t( 'Informacje' ),
		'title'    => inlife_t( 'Wyniki i archiwum ogłoszeń' ),
		'lead'     => inlife_t( 'Sprawdź wyniki zakończonych naborów oraz archiwalne ogłoszenia o pracę i konkursy na stanowiska naukowe.' ),
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
			<?php echo esc_html( inlife_t( 'Zobacz wyniki zakończonych konkursów i procesów rekrutacyjnych.' ) ); ?>
		</p>

		<span class="c-readmore career-opportunities-entry-card__readmore">
			<span class="c-readmore__label">
				<?php echo esc_html( inlife_t( 'Przejdź do wyników' ) ); ?>
			</span>
			<span class="c-readmore__icon" aria-hidden="true">→</span>
		</span>
	</a>

	<a class="c-surface c-surface--panel career-opportunities-entry-card" href="<?php echo esc_url( $archive_url ); ?>">
		<h3 class="career-opportunities-entry-card__title">
			<?php echo esc_html( inlife_get_career_type_label( 'archive' ) ); ?>
		</h3>

		<p class="career-opportunities-entry-card__text">
			<?php echo esc_html( inlife_t( 'Przeglądaj archiwalne ogłoszenia o pracę i konkursy.' ) ); ?>
		</p>

		<span class="c-readmore career-opportunities-entry-card__readmore">
			<span class="c-readmore__label">
				<?php echo esc_html( inlife_t( 'Zobacz archiwum' ) ); ?>
			</span>
			<span class="c-readmore__icon" aria-hidden="true">→</span>
		</span>
	</a>

</div>
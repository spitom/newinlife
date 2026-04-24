<?php
/**
 * Career trainings section
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

$section_kicker = function_exists( 'get_field' ) ? get_field( 'career_trainings_kicker', $post_id ) : '';
$section_title  = function_exists( 'get_field' ) ? get_field( 'career_trainings_title', $post_id ) : '';
$section_text   = function_exists( 'get_field' ) ? get_field( 'career_trainings_text', $post_id ) : '';
$cta_label      = function_exists( 'get_field' ) ? get_field( 'career_trainings_cta_label', $post_id ) : '';
$cta_url        = function_exists( 'get_field' ) ? get_field( 'career_trainings_cta_url', $post_id ) : '';

$section_kicker = $section_kicker ?: inlife_t( 'Rozwój' );
$section_title  = $section_title ?: inlife_t( 'Szkolenia i rozwój kompetencji' );
$section_text   = $section_text ?: inlife_t( 'Wspieramy rozwój kompetencji zawodowych i naukowych poprzez szkolenia, warsztaty oraz inicjatywy rozwojowe. W tej sekcji docelowo może pojawić się harmonogram, kalendarz i możliwość zapisów.' );
$cta_label      = $cta_label ?: inlife_t( 'Zobacz szkolenia' );
$cta_url        = $cta_url ?: '#';

$items = [
	[
		'title' => inlife_t( 'Warsztaty i kursy' ),
		'text'  => inlife_t( 'Rozwój praktycznych kompetencji wspierających pracę naukową, organizacyjną i projektową.' ),
	],
	[
		'title' => inlife_t( 'Kalendarz szkoleń' ),
		'text'  => inlife_t( 'Docelowo sekcja może prezentować harmonogram nadchodzących szkoleń i terminów zapisów.' ),
	],
	[
		'title' => inlife_t( 'Rozwój długofalowy' ),
		'text'  => inlife_t( 'Szkolenia wpisują się w szerszy model wzmacniania kompetencji oraz planowania ścieżek rozwoju.' ),
	],
];

if ( function_exists( 'have_rows' ) && have_rows( 'career_trainings_items', $post_id ) ) {
	$items = [];

	while ( have_rows( 'career_trainings_items', $post_id ) ) {
		the_row();

		$title = get_sub_field( 'title' );
		$text  = get_sub_field( 'text' );

		if ( ! $title && ! $text ) {
			continue;
		}

		$items[] = [
			'title' => $title ?: '',
			'text'  => $text ?: '',
		];
	}
}

$action_html = '';

if ( $cta_label && $cta_url ) {
	$action_html = sprintf(
		'<a href="%s" class="btn btn-outline-primary">%s</a>',
		esc_url( $cta_url ),
		esc_html( $cta_label )
	);
}
?>

<div class="career-trainings">

	<?php
	get_template_part(
		'template-parts/components/section-header',
		null,
		[
			'kicker'      => $section_kicker,
			'title'       => $section_title,
			'lead'        => $section_text,
			'action_html' => $action_html,
			'title_id'    => 'career-trainings-heading',
		]
	);
	?>

	<?php if ( ! empty( $items ) ) : ?>
		<div class="career-trainings__grid c-card-grid c-card-grid--3">
			<?php foreach ( $items as $item ) : ?>
				<article class="career-trainings__item c-surface c-surface--panel">
					<?php if ( ! empty( $item['title'] ) ) : ?>
						<h3 class="career-trainings__title">
							<?php echo esc_html( $item['title'] ); ?>
						</h3>
					<?php endif; ?>

					<?php if ( ! empty( $item['text'] ) ) : ?>
						<p class="career-trainings__text">
							<?php echo esc_html( $item['text'] ); ?>
						</p>
					<?php endif; ?>

					<div class="career-trainings__readmore">
						<?php
						get_template_part(
							'template-parts/components/readmore',
							null,
							[
								'label' => inlife_t( 'Przejdź dalej' ),
								'url'   => $cta_url,
							]
						);
						?>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

</div>
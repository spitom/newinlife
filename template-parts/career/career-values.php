<?php
/**
 * Career values
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

$section_kicker = function_exists( 'get_field' ) ? get_field( 'career_values_kicker', $post_id ) : '';
$section_title  = function_exists( 'get_field' ) ? get_field( 'career_values_title', $post_id ) : '';
$section_text   = function_exists( 'get_field' ) ? get_field( 'career_values_text', $post_id ) : '';

$section_kicker = $section_kicker ?: inlife_t( 'Wartości' );
$section_title  = $section_title ?: inlife_t( 'Nasze wartości i kultura pracy' );
$section_text   = $section_text ?: inlife_t( 'Tworzymy środowisko pracy oparte na współpracy, odpowiedzialności i rozwoju. Łączymy wysokie standardy naukowe z codzienną kulturą organizacyjną, w której liczą się relacje, wzajemny szacunek i realne możliwości wzrostu.' );

$highlights = [
	[
		'title' => inlife_t( 'Współpraca' ),
		'text'  => inlife_t( 'Budujemy zespoły, w których wiedza i doświadczenie są wymieniane między obszarami i pokoleniami.' ),
	],
	[
		'title' => inlife_t( 'Rozwój' ),
		'text'  => inlife_t( 'Wspieramy rozwój kompetencji, ścieżki naukowe, zawodowe i wejście w nowe role.' ),
	],
	[
		'title' => inlife_t( 'Odpowiedzialność' ),
		'text'  => inlife_t( 'Dbamy o jakość pracy, etykę działania i szacunek wobec ludzi, partnerów oraz otoczenia.' ),
	],
];

if ( function_exists( 'have_rows' ) && have_rows( 'career_values_highlights', $post_id ) ) {
	$highlights = [];

	while ( have_rows( 'career_values_highlights', $post_id ) ) {
		the_row();

		$item_title = get_sub_field( 'title' );
		$item_text  = get_sub_field( 'text' );

		if ( ! $item_title && ! $item_text ) {
			continue;
		}

		$highlights[] = [
			'title' => $item_title ?: '',
			'text'  => $item_text ?: '',
		];
	}
}

$highlights = array_slice( $highlights, 0, 3 );
?>

<div class="career-values">
	<?php
	get_template_part(
		'template-parts/components/section-header',
		null,
		[
			'kicker'   => $section_kicker,
			'title'    => $section_title,
			'lead'     => $section_text,
			'title_id' => 'career-values-heading',
		]
	);
	?>

	<?php if ( ! empty( $highlights ) ) : ?>
		<div class="career-values__grid c-card-grid c-card-grid--3">
			<?php foreach ( $highlights as $item ) : ?>
				<article class="career-values__item c-surface c-surface--panel">
					<?php if ( ! empty( $item['title'] ) ) : ?>
						<h3 class="career-values__item-title">
							<?php echo esc_html( $item['title'] ); ?>
						</h3>
					<?php endif; ?>

					<?php if ( ! empty( $item['text'] ) ) : ?>
						<p class="career-values__item-text">
							<?php echo esc_html( $item['text'] ); ?>
						</p>
					<?php endif; ?>
				</article>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>
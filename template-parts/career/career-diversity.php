<?php
/**
 * Career diversity section
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

$section_kicker = function_exists( 'get_field' ) ? get_field( 'career_diversity_kicker', $post_id ) : '';
$section_title  = function_exists( 'get_field' ) ? get_field( 'career_diversity_title', $post_id ) : '';
$section_text   = function_exists( 'get_field' ) ? get_field( 'career_diversity_text', $post_id ) : '';

$section_kicker = $section_kicker ?: inlife_t( 'Różnorodność' );
$section_title  = $section_title ?: inlife_t( 'Deklaracja poszanowania różnorodności' );
$section_text   = $section_text ?: inlife_t( 'Tworzymy środowisko pracy i rozwoju, w którym szacunek, równe traktowanie i otwartość są podstawą współpracy. Wierzymy, że różnorodność doświadczeń, perspektyw i kompetencji wzmacnia jakość pracy zespołowej oraz wspiera rozwój całej organizacji.' );

$points = [
	[
		'title' => inlife_t( 'Szacunek' ),
		'text'  => inlife_t( 'Dbamy o kulturę pracy opartą na wzajemnym szacunku i odpowiedzialnej komunikacji.' ),
	],
	[
		'title' => inlife_t( 'Równe traktowanie' ),
		'text'  => inlife_t( 'Wspieramy przejrzyste zasady współpracy, rozwoju i uczestnictwa w życiu organizacji.' ),
	],
	[
		'title' => inlife_t( 'Otwartość' ),
		'text'  => inlife_t( 'Tworzymy przestrzeń dla różnych doświadczeń, ścieżek rozwoju i perspektyw.' ),
	],
];

if ( function_exists( 'have_rows' ) && have_rows( 'career_diversity_points', $post_id ) ) {
	$points = [];

	while ( have_rows( 'career_diversity_points', $post_id ) ) {
		the_row();

		$title = get_sub_field( 'title' );
		$text  = get_sub_field( 'text' );

		if ( ! $title && ! $text ) {
			continue;
		}

		$points[] = [
			'title' => $title ?: '',
			'text'  => $text ?: '',
		];
	}
}
?>

<div class="career-diversity">

	<?php
	get_template_part(
		'template-parts/components/section-header',
		null,
		[
			'kicker'   => $section_kicker,
			'title'    => $section_title,
			'title_id' => 'career-diversity-heading',
		]
	);
	?>

	<div class="career-diversity__layout">
		<div class="career-diversity__content">
			<?php if ( $section_text ) : ?>
				<div class="career-diversity__text">
					<?php echo wp_kses_post( wpautop( $section_text ) ); ?>
				</div>
			<?php endif; ?>
		</div>

		<?php if ( ! empty( $points ) ) : ?>
			<div class="career-diversity__points">
				<?php foreach ( $points as $point ) : ?>
					<article class="career-diversity__point">
						<?php if ( ! empty( $point['title'] ) ) : ?>
							<h3 class="career-diversity__point-title">
								<?php echo esc_html( $point['title'] ); ?>
							</h3>
						<?php endif; ?>

						<?php if ( ! empty( $point['text'] ) ) : ?>
							<p class="career-diversity__point-text">
								<?php echo esc_html( $point['text'] ); ?>
							</p>
						<?php endif; ?>
					</article>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>

</div>
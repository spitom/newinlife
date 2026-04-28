<?php
/**
 * Business cooperation
 *
 * @package UnderStrap
 */

defined('ABSPATH') || exit;

$post_id = get_the_ID();

$section_kicker = inlife_get_acf_field(
	'business_cooperation_kicker',
	$post_id,
	'Współpraca'
);

$section_title = inlife_get_acf_field(
	'business_cooperation_title',
	$post_id,
	'Jak możemy współpracować'
);

$section_text = inlife_get_acf_field(
	'business_cooperation_text',
	$post_id,
	'Współpracujemy z partnerami biznesowymi na różnych etapach rozwoju produktu, procesu lub technologii. Łączymy zaplecze badawcze, kompetencje eksperckie oraz elastyczne podejście do potrzeb organizacji.'
);

$cta_title = inlife_get_acf_field(
	'business_cooperation_cta_title',
	$post_id,
	'Porozmawiajmy o Twoich potrzebach'
);

$cta_text = inlife_get_acf_field(
	'business_cooperation_cta_text',
	$post_id,
	'Skontaktuj się z nami, aby omówić możliwe modele współpracy, zakres usług oraz ścieżkę dalszych działań.'
);

$cta_label = inlife_get_acf_field(
	'business_cooperation_cta_label',
	$post_id,
	'Przejdź do kontaktu'
);

$cta_url = inlife_get_acf_field(
	'business_cooperation_cta_url',
	$post_id,
	'#business-contact-heading'
);

$points = [
	[
		'title' => 'Ekspertyzy i analizy',
		'text'  => 'Realizujemy badania, konsultacje i opracowania wspierające decyzje technologiczne oraz produktowe.',
	],
	[
		'title' => 'Projekty rozwojowe',
		'text'  => 'Wspieramy rozwój nowych rozwiązań, walidację koncepcji i przygotowanie do wdrożeń.',
	],
	[
		'title' => 'Długofalowe partnerstwa',
		'text'  => 'Budujemy współpracę opartą na zaufaniu, wiedzy eksperckiej i wspólnym rozwoju kompetencji.',
	],
];

if (function_exists('have_rows') && have_rows('business_cooperation_points', $post_id)) {
	$points = [];

	while (have_rows('business_cooperation_points', $post_id)) {
		the_row();

		$point_title = get_sub_field('title');
		$point_text  = get_sub_field('text');

		$points[] = [
			'title' => $point_title ?: '',
			'text'  => $point_text ?: '',
		];
	}
}
?>

<div class="business-cooperation">
	<?php
	get_template_part(
		'template-parts/components/section-header',
		null,
		[
			'kicker'   => $section_kicker,
			'title'    => $section_title,
			'lead'     => $section_text,
			'title_id' => 'business-cooperation-heading',
		]
	);
	?>

	<div class="business-cooperation__layout c-section-split c-section-split--main-wide">
		<div class="business-cooperation__content c-section-split__main">
			<?php if ( ! empty( $points ) ) : ?>
				<div class="business-cooperation__points">
					<?php foreach ( $points as $point ) : ?>
						<article class="business-cooperation__point">
							<h3 class="business-cooperation__point-title">
								<?php echo esc_html( $point['title'] ); ?>
							</h3>

							<?php if ( ! empty( $point['text'] ) ) : ?>
								<p class="business-cooperation__point-text">
									<?php echo esc_html( $point['text'] ); ?>
								</p>
							<?php endif; ?>
						</article>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>

		<aside class="business-cooperation__aside c-section-split__aside">
			<div class="business-cooperation__cta">
				<h3 class="business-cooperation__cta-title">
					<?php echo esc_html( $cta_title ); ?>
				</h3>

				<p class="business-cooperation__cta-text">
					<?php echo esc_html( $cta_text ); ?>
				</p>

				<a class="business-cooperation__cta-link btn btn-primary" href="<?php echo esc_url( $cta_url ); ?>">
					<?php echo esc_html( $cta_label ); ?>
				</a>
			</div>
		</aside>
	</div>
</div>
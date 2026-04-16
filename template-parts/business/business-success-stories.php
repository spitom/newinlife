<?php
/**
 * Business success stories
 *
 * @package UnderStrap
 */

defined('ABSPATH') || exit;

$post_id = get_the_ID();

if (!function_exists('inlife_get_acf_field')) {
	function inlife_get_acf_field($field_name, $post_id = 0, $default = null) {
		if (function_exists('get_field')) {
			$value = get_field($field_name, $post_id);

			if ($value !== null && $value !== '') {
				return $value;
			}
		}

		return $default;
	}
}

$section_kicker = inlife_get_acf_field(
	'business_success_stories_kicker',
	$post_id,
	'Nasze sukcesy'
);

$section_title = inlife_get_acf_field(
	'business_success_stories_title',
	$post_id,
	'Wybrane przykłady współpracy i wdrożeń'
);

$section_text = inlife_get_acf_field(
	'business_success_stories_text',
	$post_id,
	'Pokazujemy przykłady projektów, wdrożeń i działań realizowanych we współpracy z partnerami zewnętrznymi. To konkretne efekty łączenia badań, technologii i praktyki.'
);

$stories = [
	[
		'title'   => 'Optymalizacja jakości produktu w projekcie dla partnera z branży spożywczej',
		'text'    => 'Zespół instytutu wsparł analizę parametrów jakościowych oraz przygotowanie rekomendacji dla dalszego rozwoju produktu.',
		'result'  => 'Efekt: lepsza kontrola jakości i usprawnienie procesu decyzyjnego.',
		'url'     => '#',
		'badge'   => 'Case study',
		'meta'    => 'Poznaj historię',
	],
	[
		'title'   => 'Wsparcie eksperckie dla procesu wdrożeniowego',
		'text'    => 'Przeprowadzono badania i konsultacje pozwalające ograniczyć ryzyko na etapie przygotowania rozwiązania do wdrożenia.',
		'result'  => 'Efekt: szybsze przejście do etapu testów i walidacji.',
		'url'     => '#',
		'badge'   => 'Współpraca',
		'meta'    => 'Zobacz efekt',
	],
	[
		'title'   => 'Rozwój rozwiązania o potencjale aplikacyjnym',
		'text'    => 'Połączono wiedzę zespołu badawczego i potrzeby partnera biznesowego, tworząc podstawy dalszego rozwoju technologii.',
		'result'  => 'Efekt: gotowy kierunek dalszych prac i rozwoju produktu.',
		'url'     => '#',
		'badge'   => 'Technologia',
		'meta'    => 'Sprawdź przykład',
	],
];

/**
 * ACF repeater
 */
if (function_exists('have_rows') && have_rows('business_success_story_tiles', $post_id)) {
	$stories = [];

	while (have_rows('business_success_story_tiles', $post_id)) {
		the_row();

		$title  = get_sub_field('title');
		$text   = get_sub_field('text');
		$result = get_sub_field('result');
		$link   = get_sub_field('link');
		$badge  = get_sub_field('badge');
		$meta   = get_sub_field('meta');

		$url = '#';

		if (is_array($link) && !empty($link['url'])) {
			$url = $link['url'];
		} elseif (is_string($link) && !empty($link)) {
			$url = $link;
		}

		$stories[] = [
			'title'  => $title ?: '',
			'text'   => $text ?: '',
			'result' => $result ?: '',
			'url'    => $url,
			'badge'  => $badge ?: 'Case study',
			'meta'   => $meta ?: 'Dowiedz się więcej',
		];
	}
}

$featured_story    = $stories[0] ?? null;
$secondary_stories = array_slice($stories, 1);
?>

<div class="business-success-stories">
	<?php
	get_template_part(
		'template-parts/components/section-header',
		null,
		[
			'kicker'   => $section_kicker,
			'title'    => $section_title,
			'lead'     => $section_text,
			'title_id' => 'business-success-stories-heading',
		]
	);
	?>

	<?php if ( $featured_story || ! empty( $secondary_stories ) ) : ?>
		<div class="business-success-stories__layout">

			<?php if ( $featured_story ) : ?>
				<article class="business-success-card business-success-card--featured">
					<a class="business-success-card__link" href="<?php echo esc_url( $featured_story['url'] ); ?>">
						<div class="business-success-card__media" aria-hidden="true">
							<div class="business-success-card__placeholder">
								<span class="business-success-card__badge">
									<?php echo esc_html( $featured_story['badge'] ); ?>
								</span>
							</div>
						</div>

						<div class="business-success-card__body">
							<h3 class="business-success-card__title">
								<?php echo esc_html( $featured_story['title'] ); ?>
							</h3>

							<?php if ( ! empty( $featured_story['text'] ) ) : ?>
								<p class="business-success-card__text">
									<?php echo esc_html( $featured_story['text'] ); ?>
								</p>
							<?php endif; ?>

							<?php if ( ! empty( $featured_story['result'] ) ) : ?>
								<p class="business-success-card__result">
									<?php echo esc_html( $featured_story['result'] ); ?>
								</p>
							<?php endif; ?>

							<span class="business-success-card__meta">
								<?php echo esc_html( $featured_story['meta'] ); ?>
							</span>
						</div>
					</a>
				</article>
			<?php endif; ?>

			<?php if ( ! empty( $secondary_stories ) ) : ?>
				<div class="business-success-stories__aside">
					<?php foreach ( $secondary_stories as $story ) : ?>
						<article class="business-success-card business-success-card--standard">
							<a class="business-success-card__link" href="<?php echo esc_url( $story['url'] ); ?>">
								<div class="business-success-card__body">
									<span class="business-success-card__badge business-success-card__badge--inline">
										<?php echo esc_html( $story['badge'] ); ?>
									</span>

									<h3 class="business-success-card__title">
										<?php echo esc_html( $story['title'] ); ?>
									</h3>

									<?php if ( ! empty( $story['text'] ) ) : ?>
										<p class="business-success-card__text">
											<?php echo esc_html( $story['text'] ); ?>
										</p>
									<?php endif; ?>

									<?php if ( ! empty( $story['result'] ) ) : ?>
										<p class="business-success-card__result">
											<?php echo esc_html( $story['result'] ); ?>
										</p>
									<?php endif; ?>

									<span class="business-success-card__meta">
										<?php echo esc_html( $story['meta'] ); ?>
									</span>
								</div>
							</a>
						</article>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

		</div>
	<?php endif; ?>
</div>
<?php
/**
 * Career location promo
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
	'career_location_kicker',
	$post_id,
	'Lokalizacja'
);

$section_title = inlife_get_acf_field(
	'career_location_title',
	$post_id,
	'Polska / Olsztyn / InLife'
);

$section_text = inlife_get_acf_field(
	'career_location_text',
	$post_id,
	'Olsztyn to nowoczesne miasto akademickie położone w regionie Warmii i Mazur, łączące rozwój naukowy z wyjątkowym otoczeniem przyrodniczym.'
);

/**
 * Fallback content – oparty o realne fakty
 */
$items = [
	[
		'title' => 'Miasto nauki',
		'text'  => 'Olsztyn jest ważnym ośrodkiem akademickim i kulturalnym regionu, z rozwiniętą infrastrukturą naukową i edukacyjną.', // :contentReference[oaicite:0]{index=0}
		'url'   => 'https://visit.olsztyn.eu',
	],
	[
		'title' => 'Miasto jezior',
		'text'  => 'Na terenie miasta znajduje się kilkanaście jezior i rozległe tereny zielone, co tworzy wyjątkowe warunki do życia i pracy.', // :contentReference[oaicite:1]{index=1}
		'url'   => 'https://visit.olsztyn.eu',
	],
	[
		'title' => 'Historia i kultura',
		'text'  => 'Miasto łączy bogate dziedzictwo historyczne z nowoczesną przestrzenią miejską i aktywnym życiem kulturalnym.', // :contentReference[oaicite:2]{index=2}
		'url'   => 'https://visit.olsztyn.eu',
	],
	[
		'title' => 'Środowisko pracy',
		'text'  => 'Instytut działa w otoczeniu sprzyjającym rozwojowi naukowemu oraz współpracy międzynarodowej.',
		'url'   => '#',
	],
];

if (function_exists('have_rows') && have_rows('career_location_items', $post_id)) {
	$items = [];

	while (have_rows('career_location_items', $post_id)) {
		the_row();

		$link = get_sub_field('link');
		$url  = '#';

		if (is_array($link) && !empty($link['url'])) {
			$url = $link['url'];
		} elseif (is_string($link) && !empty($link)) {
			$url = $link;
		}

		$items[] = [
			'title' => get_sub_field('title') ?: '',
			'text'  => get_sub_field('text') ?: '',
			'url'   => $url,
		];
	}
}
?>

<div class="career-location">
	<div class="row g-4 align-items-end career-section-head">
		<div class="col-lg-8">
			<div class="section-heading mb-0">
				<p class="section-kicker"><?php echo esc_html($section_kicker); ?></p>
				<h2 id="career-location-heading" class="section-title">
					<?php echo esc_html($section_title); ?>
				</h2>
			</div>

			<?php if (!empty($section_text)) : ?>
				<p class="section-lead mt-3 mb-0">
					<?php echo esc_html($section_text); ?>
				</p>
			<?php endif; ?>
		</div>
	</div>

	<?php if (!empty($items)) : ?>
		<div class="career-location__grid">
			<?php foreach ($items as $item) : ?>
				<article class="career-location__card">
					<a href="<?php echo esc_url($item['url']); ?>" class="career-location__link">
						<h3 class="career-location__title">
							<?php echo esc_html($item['title']); ?>
						</h3>

						<?php if (!empty($item['text'])) : ?>
							<p class="career-location__text">
								<?php echo esc_html($item['text']); ?>
							</p>
						<?php endif; ?>

						<span class="career-location__cta">
							Dowiedz się więcej
						</span>
					</a>
				</article>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>
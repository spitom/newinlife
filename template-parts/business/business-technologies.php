<?php
/**
 * Business technologies
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
	'business_technologies_kicker',
	$post_id,
	'Nasze technologie'
);

$section_title = inlife_get_acf_field(
	'business_technologies_title',
	$post_id,
	'Patenty, know-how i rozwiązania gotowe do współpracy'
);

$section_text = inlife_get_acf_field(
	'business_technologies_text',
	$post_id,
	'Rozwijamy rozwiązania o potencjale wdrożeniowym i transferowym. Łączymy badania, doświadczenie eksperckie oraz zaplecze instytutowe, aby wspierać partnerów biznesowych w rozwoju nowych produktów i procesów.'
);

/**
 * Fallback tiles
 */
$tiles = [
	[
		'title'   => 'Patenty',
		'text'    => 'Rozwiązania o potencjale komercjalizacyjnym, gotowe do dalszych rozmów wdrożeniowych i rozwojowych.',
		'url'     => '#',
		'badge'   => 'Technologia',
		'meta'    => 'Poznaj portfolio',
	],
	[
		'title'   => 'Know-how',
		'text'    => 'Specjalistyczna wiedza i doświadczenie zespołów badawczych dostępne w modelu współpracy z partnerami zewnętrznymi.',
		'url'     => '#',
		'badge'   => 'Kompetencje',
		'meta'    => 'Sprawdź możliwości',
	],
	[
		'title'   => 'Rozwiązania dla rynku',
		'text'    => 'Wybrane technologie, procedury i modele współpracy wspierające wdrożenia oraz rozwój produktów.',
		'url'     => '#',
		'badge'   => 'Wdrożenia',
		'meta'    => 'Zobacz obszary',
	],
];

/**
 * ACF repeater
 */
if (function_exists('have_rows') && have_rows('business_technology_tiles', $post_id)) {
	$tiles = [];

	while (have_rows('business_technology_tiles', $post_id)) {
		the_row();

		$title = get_sub_field('title');
		$text  = get_sub_field('text');
		$link  = get_sub_field('link');
		$badge = get_sub_field('badge');
		$meta  = get_sub_field('meta');

		$url = '#';

		if (is_array($link) && !empty($link['url'])) {
			$url = $link['url'];
		} elseif (is_string($link) && !empty($link)) {
			$url = $link;
		}

		$tiles[] = [
			'title' => $title ?: '',
			'text'  => $text ?: '',
			'url'   => $url,
			'badge' => $badge ?: 'Technologia',
			'meta'  => $meta ?: 'Dowiedz się więcej',
		];
	}
}
?>

<div class="business-technologies">
	<div class="row g-4 align-items-end business-section-head">
		<div class="col-lg-8">
			<div class="section-heading mb-0">
				<p class="section-kicker"><?php echo esc_html($section_kicker); ?></p>
				<h2 id="business-technologies-heading" class="section-title">
					<?php echo esc_html($section_title); ?>
				</h2>
			</div>

			<?php if (!empty($section_text)) : ?>
				<p class="section-lead mt-3 mb-0">
					<?php echo esc_html($section_text); ?>
				</p>
			<?php endif; ?>
		</div>

		<div class="col-lg-4 text-lg-end">
			<a href="#" class="btn btn-outline-primary">Zobacz wszystkie technologie</a>
		</div>
	</div>

	<?php if (!empty($tiles)) : 
	$main = $tiles[0] ?? null;
	$side = array_slice($tiles, 1);
	?>

	<div class="business-technologies__layout">

		<?php if ($main) : ?>
			<article class="business-tech-panel business-tech-panel--main">
				<a class="business-tech-panel__link" href="<?php echo esc_url($main['url']); ?>">
					<div class="business-tech-panel__content">
						<span class="business-tech-panel__badge">
							<?php echo esc_html($main['badge']); ?>
						</span>

						<h3 class="business-tech-panel__title">
							<?php echo esc_html($main['title']); ?>
						</h3>

						<?php if (!empty($main['text'])) : ?>
							<p class="business-tech-panel__text">
								<?php echo esc_html($main['text']); ?>
							</p>
						<?php endif; ?>

						<span class="business-tech-panel__meta">
							<?php echo esc_html($main['meta']); ?>
						</span>
					</div>
				</a>
			</article>
		<?php endif; ?>

		<?php if (!empty($side)) : ?>
			<div class="business-tech-panel__aside">
				<?php foreach ($side as $tile) : ?>
					<article class="business-tech-panel business-tech-panel--side">
						<a class="business-tech-panel__link" href="<?php echo esc_url($tile['url']); ?>">
							<span class="business-tech-panel__badge">
								<?php echo esc_html($tile['badge']); ?>
							</span>

							<h3 class="business-tech-panel__title">
								<?php echo esc_html($tile['title']); ?>
							</h3>

							<?php if (!empty($tile['text'])) : ?>
								<p class="business-tech-panel__text">
									<?php echo esc_html($tile['text']); ?>
								</p>
							<?php endif; ?>

							<span class="business-tech-panel__meta">
								<?php echo esc_html($tile['meta']); ?>
							</span>
						</a>
					</article>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

	</div>

	<?php endif; ?>
</div>
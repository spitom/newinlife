<?php
/**
 * Business services by industries
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
	'business_services_industries_kicker',
	$post_id,
	'Katalog usług'
);

$section_title = inlife_get_acf_field(
	'business_services_industries_title',
	$post_id,
	'Usługi według branż'
);

$section_text = inlife_get_acf_field(
	'business_services_industries_text',
	$post_id,
	'Wspieramy partnerów z różnych sektorów gospodarki, oferując ekspertyzę naukową, zaplecze laboratoryjne oraz rozwiązania dopasowane do potrzeb konkretnych branż.'
);

$tiles = [
	[
		'title'   => 'Piekarnie',
		'text'    => 'Wsparcie analityczne i eksperckie dla produktów piekarniczych oraz procesów technologicznych.',
		'url'     => '#',
		'badge'   => 'Branża',
		'variant' => 'industry',
	],
	[
		'title'   => 'Mleczarnie',
		'text'    => 'Badania jakości, bezpieczeństwa i parametrów surowców oraz produktów mlecznych.',
		'url'     => '#',
		'badge'   => 'Branża',
		'variant' => 'industry',
	],
	[
		'title'   => 'Przemysł mięsny',
		'text'    => 'Ocena jakości, trwałości i zgodności produktów z wymaganiami branżowymi.',
		'url'     => '#',
		'badge'   => 'Branża',
		'variant' => 'industry',
	],
	[
		'title'   => 'Suplementy i nutraceutyki',
		'text'    => 'Ekspertyzy, walidacja oraz wsparcie dla rozwoju produktów funkcjonalnych.',
		'url'     => '#',
		'badge'   => 'Branża',
		'variant' => 'industry',
	],
];

if (function_exists('have_rows') && have_rows('business_industry_tiles', $post_id)) {
	$tiles = [];

	while (have_rows('business_industry_tiles', $post_id)) {
		the_row();

		$title = get_sub_field('title');
		$text  = get_sub_field('text');
		$link  = get_sub_field('link');
		$badge = get_sub_field('badge');

		$url = '#';

		if (is_array($link) && !empty($link['url'])) {
			$url = $link['url'];
		} elseif (is_string($link) && !empty($link)) {
			$url = $link;
		}

		$tiles[] = [
			'title'   => $title ?: '',
			'text'    => $text ?: '',
			'url'     => $url,
			'badge'   => $badge ?: 'Branża',
			'variant' => 'industry',
		];
	}
}
?>

<div class="business-services business-services--industries">
	<div class="row g-4 align-items-end business-section-head">
		<div class="col-lg-8">
			<div class="section-heading mb-0">
				<p class="section-kicker"><?php echo esc_html($section_kicker); ?></p>
				<h2 id="business-services-industries-heading" class="section-title">
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


	<?php if (!empty($tiles)) : ?>
		<div class="business-services__grid business-services__grid--industries">
			<?php foreach ($tiles as $tile) : ?>
				<article class="business-service-card business-service-card--industry">
					<a class="business-service-card__link" href="<?php echo esc_url($tile['url']); ?>">
						<div class="business-service-card__media" aria-hidden="true">
							<div class="business-service-card__placeholder">
								<span class="business-service-card__badge">
									<?php echo esc_html($tile['badge']); ?>
								</span>
							</div>
						</div>

						<div class="business-service-card__body">
							<h3 class="business-service-card__title">
								<?php echo esc_html($tile['title']); ?>
							</h3>

							<?php if (!empty($tile['text'])) : ?>
								<p class="business-service-card__text">
									<?php echo esc_html($tile['text']); ?>
								</p>
							<?php endif; ?>

							<span class="business-service-card__meta">
								Zobacz więcej
								<span class="visually-hidden">
									o obszarze <?php echo esc_html($tile['title']); ?>
								</span>
							</span>
						</div>
					</a>
				</article>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>
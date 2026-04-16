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
	],
	[
		'title'   => 'Mleczarnie',
		'text'    => 'Badania jakości, bezpieczeństwa i parametrów surowców oraz produktów mlecznych.',
		'url'     => '#',
		'badge'   => 'Branża',
	],
	[
		'title'   => 'Przemysł mięsny',
		'text'    => 'Ocena jakości, trwałości i zgodności produktów z wymaganiami branżowymi.',
		'url'     => '#',
		'badge'   => 'Branża',
	],
	[
		'title'   => 'Suplementy i nutraceutyki',
		'text'    => 'Ekspertyzy, walidacja oraz wsparcie dla rozwoju produktów funkcjonalnych.',
		'url'     => '#',
		'badge'   => 'Branża',
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
			'title' => $title ?: '',
			'text'  => $text ?: '',
			'url'   => $url,
			'badge' => $badge ?: 'Branża',
		];
	}
}
?>

<div class="business-services business-services--industries">

	<?php
	get_template_part(
		'template-parts/components/section-header',
		null,
		[
			'kicker'   => $section_kicker,
			'title'    => $section_title,
			'lead'     => $section_text,
			'title_id' => 'business-services-industries-heading',
		]
	);
	?>

	<?php if (!empty($tiles)) : ?>
		<div class="business-services__grid business-services__grid--industries c-card-grid c-card-grid--4">
			<?php foreach ($tiles as $index => $tile) : ?>
				<article class="business-service-card business-service-card--industry c-card c-card--nav">
					<div class="business-service-card__frame c-card__frame c-card__frame--cut-tl">
						<a class="business-service-card__link business-service-card__link--nav" href="<?php echo esc_url($tile['url']); ?>">
							<div class="business-service-card__inner c-card__inner">
								<div class="business-service-card__body c-card__body">
									<div class="business-service-card__meta-row">
										<?php if (!empty($tile['badge'])) : ?>
											<span class="business-service-card__badge business-service-card__badge--soft">
												<?php echo esc_html($tile['badge']); ?>
											</span>
										<?php endif; ?>

										<span class="business-service-card__index" aria-hidden="true">
											<?php echo esc_html(str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)); ?>
										</span>
									</div>

									<h3 class="business-service-card__title c-card__title">
										<?php echo esc_html($tile['title']); ?>
									</h3>

									<?php if (!empty($tile['text'])) : ?>
										<p class="business-service-card__text">
											<?php echo esc_html($tile['text']); ?>
										</p>
									<?php endif; ?>

									<span class="c-readmore">
										<?php echo esc_html(inlife_t('Zobacz więcej')); ?>
										<span class="visually-hidden">
											<?php echo esc_html($tile['title']); ?>
										</span>
										<span class="c-readmore__icon" aria-hidden="true">→</span>
									</span>
								</div>
							</div>
						</a>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>
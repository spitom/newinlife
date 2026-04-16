<?php
/**
 * Business services by labs
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
	'business_services_labs_kicker',
	$post_id,
	'Laboratoria'
);

$section_title = inlife_get_acf_field(
	'business_services_labs_title',
	$post_id,
	'Usługi według laboratoriów'
);

$section_text = inlife_get_acf_field(
	'business_services_labs_text',
	$post_id,
	'Nasze laboratoria i zespoły badawcze zapewniają zaplecze eksperckie dla usług, analiz oraz projektów realizowanych z partnerami zewnętrznymi.'
);

$tiles = [
	[
		'title' => 'Laboratorium Analizy Żywności',
		'text'  => 'Badania jakości, bezpieczeństwa i parametrów fizykochemicznych produktów spożywczych.',
		'url'   => '#',
		'badge' => 'Laboratorium',
	],
	[
		'title' => 'Laboratorium Mikrobiologii',
		'text'  => 'Analizy mikrobiologiczne wspierające ocenę bezpieczeństwa i stabilności produktów.',
		'url'   => '#',
		'badge' => 'Laboratorium',
	],
	[
		'title' => 'Laboratorium Biotechnologii',
		'text'  => 'Zaplecze do projektów rozwojowych, wdrożeń, testów i walidacji rozwiązań.',
		'url'   => '#',
		'badge' => 'Laboratorium',
	],
	[
		'title' => 'Laboratorium Sensoryczne',
		'text'  => 'Zaplecze do projektów rozwojowych, wdrożeń, testów i walidacji rozwiązań.',
		'url'   => '#',
		'badge' => 'Laboratorium',
	],
];

if (function_exists('have_rows') && have_rows('business_lab_tiles', $post_id)) {
	$tiles = [];

	while (have_rows('business_lab_tiles', $post_id)) {
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
			'badge' => $badge ?: 'Laboratorium',
		];
	}
}
?>

<div class="business-services business-services--labs">

	<?php
	get_template_part(
		'template-parts/components/section-header',
		null,
		[
			'kicker'   => $section_kicker,
			'title'    => $section_title,
			'lead'     => $section_text,
			'title_id' => 'business-services-labs-heading',
		]
	);
	?>

	<?php if (!empty($tiles)) : ?>
		<div class="business-services__grid business-services__grid--labs c-card-grid">
			<?php foreach ($tiles as $tile) : ?>
				<article class="business-service-card business-service-card--lab c-card c-card--unit c-card--with-media">
					<div class="business-service-card__frame c-card__frame c-card__frame--cut-tl">
						<div class="business-service-card__inner c-card__inner">
							<div class="business-service-card__media c-card__media" aria-hidden="true">
								<div class="business-service-card__placeholder business-service-card__placeholder--lab c-card__placeholder">
									<span class="business-service-card__badge">
										<?php echo esc_html($tile['badge']); ?>
									</span>
								</div>
							</div>

							<div class="business-service-card__body c-card__body">
								<h3 class="business-service-card__title c-card__title">
									<a class="business-service-card__title-link c-card__title-link" href="<?php echo esc_url($tile['url']); ?>">
										<?php echo esc_html($tile['title']); ?>
									</a>
								</h3>

								<?php if (!empty($tile['text'])) : ?>
									<p class="business-service-card__text">
										<?php echo esc_html($tile['text']); ?>
									</p>
								<?php endif; ?>

								<a class="c-readmore" href="<?php echo esc_url($tile['url']); ?>">
									<?php echo esc_html(inlife_t('Poznaj kompetencje')); ?>
									<span class="visually-hidden">
										<?php echo esc_html($tile['title']); ?>
									</span>
									<span class="c-readmore__icon" aria-hidden="true">→</span>
								</a>
							</div>
						</div>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>
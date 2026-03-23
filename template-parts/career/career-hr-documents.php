<?php
/**
 * Career HR documents
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
	'career_hr_documents_kicker',
	$post_id,
	'Dokumenty'
);

$section_title = inlife_get_acf_field(
	'career_hr_documents_title',
	$post_id,
	'HR Excellence in Research'
);

$section_text = inlife_get_acf_field(
	'career_hr_documents_text',
	$post_id,
	'HR Excellence in Research to europejskie wyróżnienie przyznawane organizacjom badawczym, które rozwijają politykę kadrową zgodnie z zasadami Europejskiej Karty dla Naukowców. W tej sekcji można udostępnić dokumenty, polityki i materiały związane z tym obszarem.'
);

$logo = inlife_get_acf_field(
	'career_hr_documents_logo',
	$post_id,
	null
);

$logo_url = '';
$logo_alt = 'HR Excellence in Research';

if (is_array($logo) && !empty($logo['url'])) {
	$logo_url = $logo['url'];
	$logo_alt = !empty($logo['alt']) ? $logo['alt'] : $logo_alt;
} else {
	$logo_url = get_stylesheet_directory_uri() . '/assets/images/HR-excellence-in-research.png';
}

$documents = [
	[
		'title'       => 'HR Strategy for Researchers',
		'description' => 'Dokument opisujący podejście instytucji do wdrażania zasad HR Excellence in Research.',
		'url'         => '#',
	],
	[
		'title'       => 'Action Plan',
		'description' => 'Plan działań związanych z rozwojem polityki kadrowej i środowiska pracy naukowców.',
		'url'         => '#',
	],
	[
		'title'       => 'OTM-R Policy',
		'description' => 'Materiały dotyczące otwartej, przejrzystej i opartej na kompetencjach rekrutacji.',
		'url'         => '#',
	],
];

if (function_exists('have_rows') && have_rows('career_hr_documents', $post_id)) {
	$documents = [];

	while (have_rows('career_hr_documents', $post_id)) {
		the_row();

		$file = get_sub_field('document_file');
		$url  = '#';

		if (is_array($file) && !empty($file['url'])) {
			$url = $file['url'];
		} elseif (is_string($file) && !empty($file)) {
			$url = $file;
		}

		$documents[] = [
			'title'       => get_sub_field('document_title') ?: '',
			'description' => get_sub_field('short_description') ?: '',
			'url'         => $url,
		];
	}
}
?>

<div class="career-hr-documents">
	<div class="row g-4 align-items-end career-section-head">
		<div class="col-lg-8">
			<div class="section-heading mb-0">
				<p class="section-kicker"><?php echo esc_html($section_kicker); ?></p>
				<h2 id="career-hr-documents-heading" class="section-title">
					<?php echo esc_html($section_title); ?>
				</h2>
			</div>
		</div>
	</div>

	<div class="career-hr-documents__layout">
		<div class="career-hr-documents__intro">
			<div class="career-hr-documents__brand-card">
				<?php if (!empty($logo_url)) : ?>
					<div class="career-hr-documents__logo-wrap">
						<img
							class="career-hr-documents__logo"
							src="<?php echo esc_url($logo_url); ?>"
							alt="<?php echo esc_attr($logo_alt); ?>"
							loading="lazy"
							decoding="async"
						>
					</div>
				<?php endif; ?>

				<?php if (!empty($section_text)) : ?>
					<p class="career-hr-documents__intro-text">
						<?php echo esc_html($section_text); ?>
					</p>
				<?php endif; ?>
			</div>
		</div>

		<div class="career-hr-documents__content">
			<?php if (!empty($documents)) : ?>
				<div class="career-hr-documents__list">
					<?php foreach ($documents as $document) : ?>
						<article class="career-hr-documents__item">
							<a class="career-hr-documents__link" href="<?php echo esc_url($document['url']); ?>">
								<h3 class="career-hr-documents__item-title">
									<?php echo esc_html($document['title']); ?>
								</h3>

								<?php if (!empty($document['description'])) : ?>
									<p class="career-hr-documents__item-text">
										<?php echo esc_html($document['description']); ?>
									</p>
								<?php endif; ?>

								<span class="career-hr-documents__item-cta">Pobierz dokument</span>
							</a>
						</article>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
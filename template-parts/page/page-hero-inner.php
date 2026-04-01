<?php
defined('ABSPATH') || exit;

$passed_title   = $args['title'] ?? '';
$passed_eyebrow = $args['eyebrow'] ?? '';

$title   = '';
$eyebrow = '';

if ($passed_title) {
	$title   = $passed_title;
	$eyebrow = $passed_eyebrow;
} elseif (is_post_type_archive('projects')) {
	$title   = post_type_archive_title('', false);
	$eyebrow = '';
} elseif (is_tax('project_type')) {
	$title   = single_term_title('', false);
	$eyebrow = post_type_archive_title('', false);
} elseif (is_archive()) {
	$title   = get_the_archive_title();
	$eyebrow = '';
} else {
	$title   = get_the_title();
	$eyebrow = '';
}
?>

<section class="page-hero page-hero--inner" aria-labelledby="page-heading">
	<div class="inlife-container">
		<div class="inlife-content">
			<div class="page-hero__inner">
				<div class="page-hero__content">
					<?php if (!empty($eyebrow)) : ?>
						<p class="page-hero__eyebrow">
							<?php echo esc_html($eyebrow); ?>
						</p>
					<?php endif; ?>

					<h1 id="page-heading" class="page-hero__title">
						<?php echo esc_html($title); ?>
					</h1>
				</div>
			</div>
		</div>
	</div>
</section>
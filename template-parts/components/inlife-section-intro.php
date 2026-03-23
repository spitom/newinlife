<?php
/**
 * InLife section intro
 *
 * @package UnderStrap
 */

defined('ABSPATH') || exit;

$section_intro = get_query_var('inlife_section_intro');

if (!is_array($section_intro)) {
	$section_intro = [];
}

$kicker     = isset($section_intro['kicker']) ? $section_intro['kicker'] : '';
$title      = isset($section_intro['title']) ? $section_intro['title'] : '';
$text       = isset($section_intro['text']) ? $section_intro['text'] : '';
$heading_id = isset($section_intro['heading_id']) ? $section_intro['heading_id'] : '';
$cta_label  = isset($section_intro['cta_label']) ? $section_intro['cta_label'] : '';
$cta_url    = isset($section_intro['cta_url']) ? $section_intro['cta_url'] : '';
$cta_class  = isset($section_intro['cta_class']) ? $section_intro['cta_class'] : 'btn btn-outline-primary';

$has_content = ($kicker !== '' || $title !== '' || $text !== '');
$has_cta     = ($cta_label !== '' && $cta_url !== '');

if (!$has_content) {
	set_query_var('inlife_section_intro', null);
	return;
}
?>

<div class="row g-4 align-items-end section-intro">
	<div class="<?php echo esc_attr($has_cta ? 'col-lg-8' : 'col-12'); ?>">
		<div class="section-heading mb-0">
			<?php if ($kicker !== '') : ?>
				<p class="section-kicker"><?php echo esc_html($kicker); ?></p>
			<?php endif; ?>

			<?php if ($title !== '') : ?>
				<h2<?php echo $heading_id !== '' ? ' id="' . esc_attr($heading_id) . '"' : ''; ?> class="section-title">
					<?php echo esc_html($title); ?>
				</h2>
			<?php endif; ?>
		</div>

		<?php if ($text !== '') : ?>
			<p class="section-lead mt-3 mb-0">
				<?php echo esc_html($text); ?>
			</p>
		<?php endif; ?>
	</div>

	<?php if ($has_cta) : ?>
		<div class="col-lg-4 text-lg-end">
			<a href="<?php echo esc_url($cta_url); ?>" class="<?php echo esc_attr($cta_class); ?>">
				<?php echo esc_html($cta_label); ?>
			</a>
		</div>
	<?php endif; ?>
</div>

<?php
set_query_var('inlife_section_intro', null);
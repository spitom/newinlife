<?php
defined('ABSPATH') || exit;

$post_id = get_the_ID();

$show_rodo    = function_exists('inlife_get_acf_field') ? (bool) inlife_get_acf_field('career_show_rodo_block', $post_id, true) : true;
$rodo_variant = function_exists('inlife_get_acf_field') ? inlife_get_acf_field('career_rodo_variant', $post_id, 'standard_recruitment') : 'standard_recruitment';
$rodo_custom  = function_exists('inlife_get_acf_field') ? inlife_get_acf_field('career_rodo_custom', $post_id, '') : '';

if (!$show_rodo) {
	return;
}
?>

<div class="career-entry-rodo">
	<h2 class="career-entry-rodo__title">Informacje formalne</h2>

	<?php if ('custom' === $rodo_variant && $rodo_custom) : ?>
		<div class="career-entry-rodo__content">
			<?php echo wp_kses_post(wpautop($rodo_custom)); ?>
		</div>
	<?php else : ?>
		<div class="career-entry-rodo__content">
			<p>Treść klauzuli RODO i zgody rekrutacyjnej będzie renderowana automatycznie na podstawie wybranego wariantu.</p>
		</div>
	<?php endif; ?>
</div>
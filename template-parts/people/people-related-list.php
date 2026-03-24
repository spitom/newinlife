<?php
defined('ABSPATH') || exit;

$args = wp_parse_args(
	$args ?? [],
	[
		'leaders'        => [],
		'members'        => [],
		'title_leaders'  => '',
		'title_members'  => '',
		'heading_id'     => '',
	]
);

$leaders = is_array($args['leaders']) ? $args['leaders'] : [];
$members = is_array($args['members']) ? $args['members'] : [];

if (empty($leaders) && empty($members)) {
	return;
}
?>

<section class="people-related"
	<?php echo $args['heading_id'] ? 'aria-labelledby="' . esc_attr($args['heading_id']) . '"' : ''; ?>
>

	<?php if (!empty($leaders)) : ?>
		<div class="people-related__section people-related__section--leader">

			<div class="section-heading">
				<h2 id="<?php echo esc_attr($args['heading_id']); ?>" class="section-title">
					<?php echo esc_html($args['title_leaders'] ?: 'Kierownik zespołu'); ?>
				</h2>
			</div>

			<div class="people-related__leader">
				<?php foreach ($leaders as $post) : setup_postdata($post); ?>
					<?php get_template_part(
						'template-parts/people/people',
						'card',
						[
							'featured' => true,
						]
					); ?>
				<?php endforeach; ?>
				<?php wp_reset_postdata(); ?>
			</div>

		</div>
	<?php endif; ?>

	<?php if (!empty($members)) : ?>
		<div class="people-related__section people-related__section--members">

			<div class="section-heading">
				<h2 class="section-title">
					<?php echo esc_html($args['title_members'] ?: 'Zespół'); ?>
				</h2>
			</div>

			<div class="people-related__grid">
				<?php foreach ($members as $post) : setup_postdata($post); ?>
					<?php get_template_part(
						'template-parts/people/people',
						'card'
					); ?>
				<?php endforeach; ?>
				<?php wp_reset_postdata(); ?>
			</div>

		</div>
	<?php endif; ?>

</section>
<?php
/**
 * Taxonomy Career Entry Type
 *
 * @package UnderStrap
 */

defined('ABSPATH') || exit;

get_header();

$container = inlife_container_class();
$current_term = get_queried_object();
?>

<main id="main-content" class="site-main site-main--career-taxonomy">
	<?php get_template_part('template-parts/career/career', 'subnav', ['container' => $container]); ?>

	<section class="page-section page-section--career-taxonomy-header">
		<div class="<?php echo esc_attr($container); ?>">
			<div class="row g-4 align-items-end career-section-head">
				<div class="col-lg-8">
					<div class="section-heading mb-0">
						<p class="section-kicker">
							<?php echo function_exists('pll__') ? esc_html(pll__('Komunikaty')) : 'Komunikaty'; ?>
						</p>
						<h1 class="section-title">
							<?php echo esc_html(single_term_title('', false)); ?>
						</h1>
					</div>

					<?php if (!empty($current_term->description)) : ?>
						<p class="section-lead mt-3 mb-0">
							<?php echo esc_html($current_term->description); ?>
						</p>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>

	<section class="page-section page-section--career-taxonomy-loop">
		<div class="<?php echo esc_attr($container); ?>">
			<?php get_template_part('template-parts/career/career-archive', 'loop'); ?>
		</div>
	</section>
</main>

<?php
get_footer();
<?php
/**
 * Single Career Entry
 *
 * @package UnderStrap
 */

defined('ABSPATH') || exit;

get_header();

$container = inlife_container_class();

while (have_posts()) :
	the_post();
	?>

<main id="main-content" class="site-main site-main--career-entry">
	<?php get_template_part('template-parts/career/career-subnav'); ?>

	<section class="page-section page-section--career-entry-breadcrumbs">
		<div class="<?php echo esc_attr($container); ?>">
			<?php get_template_part('template-parts/career/career-entry', 'breadcrumbs'); ?>
		</div>
	</section>

	<section class="page-section page-section--career-entry-header">
		<div class="<?php echo esc_attr($container); ?>">
			<?php get_template_part('template-parts/career/career-entry', 'header'); ?>
		</div>
	</section>

	<section class="page-section page-section--career-entry-content">
		<div class="<?php echo esc_attr($container); ?>">
			<div class="career-entry-layout">
				<div class="career-entry-main">
					<?php get_template_part('template-parts/career/career-entry', 'content'); ?>
				</div>

				<aside class="career-entry-aside">
					<?php get_template_part('template-parts/career/career-entry', 'aside'); ?>
				</aside>
			</div>
		</div>
	</section>

	<section class="page-section page-section--career-entry-rodo">
		<div class="<?php echo esc_attr($container); ?>">
			<?php get_template_part('template-parts/career/career-entry', 'rodo'); ?>
		</div>
	</section>
</main>

<?php
endwhile;

get_footer();
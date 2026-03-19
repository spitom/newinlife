<?php
/**
 * Template Name: Badania – Overview
 *
 * @package UnderStrap
 */

defined('ABSPATH') || exit;

get_header();

$container = inlife_container_class();
?>

<main id="main-content" class="site-main site-main--landing site-main--research">

	<?php get_template_part('template-parts/page/page', 'hero-inner'); ?>

	<section class="page-section page-section--intro">
		<div class="<?php echo esc_attr($container); ?>">
			<?php get_template_part('template-parts/page/page', 'intro'); ?>
		</div>
	</section>
    
    <section class="page-section page-section--research-intro-extended" aria-labelledby="research-intro-extended-heading">
		<div class="<?php echo esc_attr($container); ?>">
			<?php get_template_part('template-parts/research/research', 'intro-extended'); ?>
		</div>
	</section>

	<section class="page-section page-section--research-units" aria-labelledby="research-units-heading">
		<div class="<?php echo esc_attr($container); ?>">
			<?php get_template_part('template-parts/research/research', 'units'); ?>
		</div>
	</section>

	<section class="page-section page-section--research-areas" aria-labelledby="research-areas-heading">
		<div class="<?php echo esc_attr($container); ?>">
			<?php get_template_part('template-parts/research/research', 'areas'); ?>
		</div>
	</section>

	<section class="page-section page-section--research-projects" aria-labelledby="research-projects-heading">
		<div class="<?php echo esc_attr($container); ?>">
			<?php get_template_part('template-parts/research/research', 'projects'); ?>
		</div>
	</section>

	<section class="page-section page-section--research-publications" aria-labelledby="research-publications-heading">
		<div class="<?php echo esc_attr($container); ?>">
			<?php get_template_part('template-parts/research/research', 'publications'); ?>
		</div>
	</section>

	<section class="page-section page-section--research-publishing" aria-labelledby="research-publishing-heading">
		<div class="<?php echo esc_attr($container); ?>">
			<?php get_template_part('template-parts/research/research', 'publishing'); ?>
		</div>
	</section>

	<section class="page-section page-section--research-seminars" aria-labelledby="research-seminars-heading">
		<div class="<?php echo esc_attr($container); ?>">
			<?php get_template_part('template-parts/research/research', 'seminars'); ?>
		</div>
	</section>

	<section class="page-section page-section--cta">
		<div class="<?php echo esc_attr($container); ?>">
			<?php get_template_part('template-parts/page/page', 'cta'); ?>
		</div>
	</section>

</main>

<?php
get_footer();
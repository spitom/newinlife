<?php
/**
 * Template Name: Kariera – Landing
 *
 * @package UnderStrap
 */

defined('ABSPATH') || exit;

get_header();

$container = inlife_container_class();
?>

<main id="main-content" class="site-main site-main--landing site-main--career">

	<section class="page-section page-section--career-hero" aria-labelledby="career-hero-heading">
		<div class="<?php echo esc_attr($container); ?>">
			<?php get_template_part('template-parts/career/career', 'hero'); ?>
		</div>
	</section>

	<section class="page-section page-section--career-values" aria-labelledby="career-values-heading">
		<div class="<?php echo esc_attr($container); ?>">
			<?php get_template_part('template-parts/career/career', 'values'); ?>
		</div>
	</section>

	<section class="page-section page-section--career-job-offers" aria-labelledby="career-job-offers-heading">
		<div class="<?php echo esc_attr($container); ?>">
			<?php get_template_part('template-parts/career/career', 'job-offers'); ?>
		</div>
	</section>

	<section class="page-section page-section--career-doctoral-school" aria-labelledby="career-doctoral-school-heading">
		<div class="<?php echo esc_attr($container); ?>">
			<?php get_template_part('template-parts/career/career', 'doctoral-school'); ?>
		</div>
	</section>

	<section class="page-section page-section--career-trainings" aria-labelledby="career-trainings-heading">
		<div class="<?php echo esc_attr($container); ?>">
			<?php get_template_part('template-parts/career/career', 'trainings'); ?>
		</div>
	</section>

	<section class="page-section page-section--career-diversity" aria-labelledby="career-diversity-heading">
		<div class="<?php echo esc_attr($container); ?>">
			<?php get_template_part('template-parts/career/career', 'diversity'); ?>
		</div>
	</section>

	<section class="page-section page-section--career-location-promo" aria-labelledby="career-location-promo-heading">
		<div class="<?php echo esc_attr($container); ?>">
			<?php get_template_part('template-parts/career/career', 'location-promo'); ?>
		</div>
	</section>

	<section class="page-section page-section--career-hr-documents" aria-labelledby="career-hr-documents-heading">
		<div class="<?php echo esc_attr($container); ?>">
			<?php get_template_part('template-parts/career/career', 'hr-documents'); ?>
		</div>
	</section>

	<section class="page-section page-section--career-onboarding" aria-labelledby="career-onboarding-heading">
		<div class="<?php echo esc_attr($container); ?>">
			<?php get_template_part('template-parts/career/career', 'onboarding'); ?>
		</div>
	</section>

</main>

<?php
get_footer();
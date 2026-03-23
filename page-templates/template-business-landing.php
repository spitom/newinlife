<?php
/**
 * Template Name: Biznes – Landing
 *
 * @package UnderStrap
 */

defined('ABSPATH') || exit;

get_header();

$container = inlife_container_class();
?>

<main id="main-content" class="site-main site-main--landing site-main--business">

	<section class="page-section page-section--business-hero" aria-labelledby="business-hero-heading">
		<div class="<?php echo esc_attr($container); ?>">
			<?php get_template_part('template-parts/business/business', 'hero'); ?>
		</div>
	</section>

	<section class="page-section page-section--business-services-industries" aria-labelledby="business-services-industries-heading">
		<div class="<?php echo esc_attr($container); ?>">
			<?php get_template_part('template-parts/business/business', 'services-industries'); ?>
		</div>
	</section>

	<section class="page-section page-section--business-services-labs" aria-labelledby="business-services-labs-heading">
		<div class="<?php echo esc_attr($container); ?>">
			<?php get_template_part('template-parts/business/business', 'services-labs'); ?>
		</div>
	</section>

	<section class="page-section page-section--business-technologies" aria-labelledby="business-technologies-heading">
		<div class="<?php echo esc_attr($container); ?>">
			<?php get_template_part('template-parts/business/business', 'technologies'); ?>
		</div>
	</section>


	<section class="page-section page-section--business-cooperation" aria-labelledby="business-cooperation-heading">
		<div class="<?php echo esc_attr($container); ?>">
			<?php get_template_part('template-parts/business/business', 'cooperation'); ?>
		</div>
	</section>

	<section class="page-section page-section--business-success-stories" aria-labelledby="business-success-stories-heading">
		<div class="<?php echo esc_attr($container); ?>">
			<?php get_template_part('template-parts/business/business', 'success-stories'); ?>
		</div>
	</section>

	<section class="page-section page-section--business-contact" aria-labelledby="business-contact-heading">
		<div class="<?php echo esc_attr($container); ?>">
			<?php get_template_part('template-parts/business/business', 'contact'); ?>
		</div>
	</section>

</main>

<?php
get_footer();
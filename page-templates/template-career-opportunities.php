<?php
/**
 * Template Name: Kariera – Konkursy i oferty
 *
 * @package UnderStrap
 */

defined('ABSPATH') || exit;

defined('ABSPATH') || exit;

get_header();

$container = inlife_container_class();
?>

<main id="main-content" class="site-main site-main--career-opportunities">

	<section class="page-section page-section--career-opportunities-hero" aria-labelledby="career-opportunities-heading">
		<div class="<?php echo esc_attr($container); ?>">
			<?php get_template_part('template-parts/career/career-opportunities', 'hero'); ?>
		</div>
	</section>

	<section class="page-section page-section--career-opportunities-nav" aria-label="Nawigacja sekcji ofert i konkursów">
		<div class="<?php echo esc_attr($container); ?>">
			<?php get_template_part('template-parts/career/career-opportunities', 'nav'); ?>
		</div>
	</section>

	<section class="page-section page-section--career-opportunities-scientific" id="konkursy-naukowe" aria-labelledby="career-scientific-heading">
		<div class="<?php echo esc_attr($container); ?>">
			<?php get_template_part('template-parts/career/career-opportunities', 'scientific'); ?>
		</div>
	</section>

	<section class="page-section page-section--career-opportunities-jobs" id="ogloszenia-o-prace" aria-labelledby="career-jobs-heading">
		<div class="<?php echo esc_attr($container); ?>">
			<?php get_template_part('template-parts/career/career-opportunities', 'jobs'); ?>
		</div>
	</section>

	<section class="page-section page-section--career-opportunities-results" id="wyniki-konkursow" aria-labelledby="career-results-heading">
		<div class="<?php echo esc_attr($container); ?>">
			<?php get_template_part('template-parts/career/career-opportunities', 'results'); ?>
		</div>
	</section>

	<section class="page-section page-section--career-opportunities-archive" id="ogloszenia-archiwalne" aria-labelledby="career-archive-heading">
		<div class="<?php echo esc_attr($container); ?>">
			<?php get_template_part('template-parts/career/career-opportunities', 'archive'); ?>
		</div>
	</section>

	<section class="page-section page-section--career-opportunities-mobility" id="mobilnosc" aria-labelledby="career-mobility-heading">
		<div class="<?php echo esc_attr($container); ?>">
			<?php get_template_part('template-parts/career/career-opportunities', 'mobility'); ?>
		</div>
	</section>

</main>

<?php
get_footer();
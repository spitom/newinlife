<?php
/**
 * Template Name: Project Hub
 */

defined('ABSPATH') || exit;

get_header();

$container = inlife_container_class();
?>

<main id="main-content" class="site-main site-main--project-hub">

	<?php get_template_part('template-parts/projects/project-hub', 'hero'); ?>

	<section class="page-section page-section--project-hub">
		<div class="<?php echo esc_attr($container); ?>">
			<div class="row g-5">
				<div class="col-lg-4 col-xl-3">
					<?php get_template_part('template-parts/projects/project', 'hub-nav'); ?>
				</div>

				<div class="col-lg-8 col-xl-9">
					<div class="project-hub-content">
						<?php
						while (have_posts()) :
							the_post();
							the_content();
						endwhile;
						?>
					</div>
				</div>
			</div>
		</div>
	</section>

</main>

<?php get_footer(); ?>
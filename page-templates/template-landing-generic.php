<?php
/**
 * Template Name: Landing – Generic
 *
 * @package UnderStrap
 */

defined('ABSPATH') || exit;

get_header();

$container = inlife_container_class();
?>

<main id="main-content" class="site-main site-main--landing">

	<?php get_template_part('template-parts/page/page', 'hero-inner'); ?>

	<section class="page-section page-section--intro">
		<div class="<?php echo esc_attr($container); ?>">
			<?php get_template_part('template-parts/page/page', 'intro'); ?>
		</div>
	</section>

	<section class="page-section page-section--content">
		<div class="<?php echo esc_attr($container); ?>">
			<div class="row g-4">
				<div class="col-12">
					<p>Placeholder content – tutaj będą sekcje właściwe.</p>
				</div>
			</div>
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
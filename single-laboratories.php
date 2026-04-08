<?php
/**
 * Single Laboratory template
 *
 * @package newinlife
 */

defined( 'ABSPATH' ) || exit;

get_header();

$container = function_exists( 'inlife_container_class' ) ? inlife_container_class() : 'container';
?>

<main id="main-content" class="site-main site-main--laboratory-single">

	<?php while ( have_posts() ) : the_post(); ?>

		<section class="page-section page-section--lab-single-hero">
			<?php get_template_part( 'template-parts/laboratories/laboratories-single', 'hero' ); ?>
		</section>

		<section class="page-section page-section--lab-single-profile">
			<div class="<?php echo esc_attr( $container ); ?>">
				<?php get_template_part( 'template-parts/laboratories/laboratories-single', 'profile' ); ?>
			</div>
		</section>

		<section class="page-section page-section--lab-single-people">
			<div class="<?php echo esc_attr( $container ); ?>">
				<?php get_template_part( 'template-parts/laboratories/laboratories-single', 'people' ); ?>
			</div>
		</section>

		<section class="page-section page-section--lab-single-methods">
			<div class="<?php echo esc_attr( $container ); ?>">
				<?php get_template_part( 'template-parts/laboratories/laboratories-single', 'methods' ); ?>
			</div>
		</section>

		<section class="page-section page-section--lab-single-equipment">
			<div class="<?php echo esc_attr( $container ); ?>">
				<?php get_template_part( 'template-parts/laboratories/laboratories-single', 'equipment' ); ?>
			</div>
		</section>

	<?php endwhile; ?>

</main>

<?php get_footer(); ?>
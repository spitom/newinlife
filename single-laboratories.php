<?php
/**
 * Single Laboratory template
 *
 * @package newinlife
 */

defined( 'ABSPATH' ) || exit;

get_header();

$container = function_exists( 'inlife_container_class' ) ? inlife_container_class() : 'container';

$laboratory_id = get_queried_object_id();

$methods_content = function_exists( 'get_field' )
	? get_field( 'laboratory_methods_content', $laboratory_id )
	: '';

$equipment_content = function_exists( 'get_field' )
	? get_field( 'laboratory_equipment_content', $laboratory_id )
	: '';

$has_methods = '' !== trim(
	wp_strip_all_tags( (string) $methods_content )
);

$has_equipment = '' !== trim(
	wp_strip_all_tags( (string) $equipment_content )
);
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

		<?php if ( $has_methods ) : ?>
			<section class="page-section page-section--lab-single-methods">
				<div class="<?php echo esc_attr( $container ); ?>">
					<?php get_template_part( 'template-parts/laboratories/laboratories-single', 'methods' ); ?>
				</div>
			</section>
		<?php endif; ?>

		<?php if ( $has_equipment ) : ?>
			<section class="page-section page-section--lab-single-equipment">
				<div class="<?php echo esc_attr( $container ); ?>">
					<?php get_template_part( 'template-parts/laboratories/laboratories-single', 'equipment' ); ?>
				</div>
			</section>
		<?php endif; ?>

	<?php endwhile; ?>

</main>

<?php get_footer(); ?>
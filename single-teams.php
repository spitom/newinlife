<?php
/**
 * Single Team template
 *
 * @package newinlife
 */

defined( 'ABSPATH' ) || exit;

get_header();

$container = function_exists( 'inlife_container_class' ) ? inlife_container_class() : 'container';
?>

<main id="main-content" class="site-main site-main--team-single">

	<?php while ( have_posts() ) : the_post(); ?>

		<section class="page-section page-section--team-single-hero">
			<?php get_template_part( 'template-parts/teams/teams-single', 'hero' ); ?>
		</section>

		<section class="page-section page-section--team-single-overview">
			<div class="<?php echo esc_attr( $container ); ?>">
				<?php get_template_part( 'template-parts/teams/teams-single', 'overview' ); ?>
			</div>
		</section>

		<section class="page-section page-section--team-single-leader">
			<div class="<?php echo esc_attr( $container ); ?>">
				<?php get_template_part( 'template-parts/teams/teams-single', 'leader' ); ?>
			</div>
		</section>

		<section class="page-section page-section--team-single-people">
			<div class="<?php echo esc_attr( $container ); ?>">
				<?php get_template_part( 'template-parts/teams/teams-single', 'people' ); ?>
			</div>
		</section>

		<section class="page-section page-section--team-single-sections">
			<div class="<?php echo esc_attr( $container ); ?>">

				<?php get_template_part( 'template-parts/teams/teams-single-sections', 'nav' ); ?>
				<?php get_template_part( 'template-parts/teams/teams-single-sections', 'panel' ); ?>

			</div>
		</section>

	<?php endwhile; ?>

</main>

<?php get_footer(); ?>
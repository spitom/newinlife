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

	<?php
	while ( have_posts() ) :
		the_post();
		?>

		<section class="page-section page-section--team-single-hero">
			<div class="<?php echo esc_attr( $container ); ?>">
				<?php get_template_part( 'template-parts/teams/teams-single', 'hero' ); ?>
			</div>
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

		<section class="page-section page-section--team-single-research">
			<div class="<?php echo esc_attr( $container ); ?>">
				<?php get_template_part( 'template-parts/teams/teams-single', 'research' ); ?>
			</div>
		</section>

		<section class="page-section page-section--team-single-projects">
			<div class="<?php echo esc_attr( $container ); ?>">
				<?php get_template_part( 'template-parts/teams/teams-single', 'projects' ); ?>
			</div>
		</section>

		<section class="page-section page-section--team-single-publications">
			<div class="<?php echo esc_attr( $container ); ?>">
				<?php get_template_part( 'template-parts/teams/teams-single', 'publications' ); ?>
			</div>
		</section>

		<section class="page-section page-section--team-single-news">
			<div class="<?php echo esc_attr( $container ); ?>">
				<?php get_template_part( 'template-parts/teams/teams-single', 'news' ); ?>
			</div>
		</section>

	<?php endwhile; ?>

</main>

<?php get_footer(); ?>
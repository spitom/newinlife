<?php
/**
 * Archive People
 *
 * @package newinlife
 */

defined( 'ABSPATH' ) || exit;

get_header();

$container = function_exists( 'inlife_container_class' ) ? inlife_container_class() : 'container';
?>

<main id="main-content" class="site-main site-main--people-archive">
	<section class="page-section page-section--people-archive">
		<div class="<?php echo esc_attr( $container ); ?>">

			<?php get_template_part( 'template-parts/people/people', 'archive-header' ); ?>
			<?php get_template_part( 'template-parts/people/people', 'search' ); ?>
			<?php get_template_part( 'template-parts/people/people', 'filters' ); ?>
			<?php get_template_part( 'template-parts/people/people', 'alpha-filter' ); ?>
			<?php get_template_part( 'template-parts/people/people', 'directory' ); ?>

		</div>
	</section>
</main>

<?php
get_footer();
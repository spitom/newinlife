<?php
/**
 * Single People
 *
 * @package newinlife
 */

defined( 'ABSPATH' ) || exit;

get_header();

$container = function_exists( 'inlife_container_class' ) ? inlife_container_class() : 'container';

while ( have_posts() ) :
	the_post();
?>

<main id="main-content" class="site-main site-main--people-single">

	<section class="page-section page-section--people-single-header">
		<div class="<?php echo esc_attr( $container ); ?>">
			<?php get_template_part( 'template-parts/people/people-single', 'header' ); ?>
		</div>
	</section>

	<section class="page-section page-section--people-single-content">
		<div class="<?php echo esc_attr( $container ); ?>">
			<div class="people-single-layout">
				<div class="people-single-main">
					<?php get_template_part( 'template-parts/people/people-single', 'bio' ); ?>
				</div>

				<aside class="people-single-aside">
					<?php get_template_part( 'template-parts/people/people-single', 'contact' ); ?>
					<?php get_template_part( 'template-parts/people/people-single', 'related-context' ); ?>
				</aside>
			</div>
		</div>
	</section>

</main>

<?php
endwhile;

get_footer();
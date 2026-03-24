<?php
/**
 * Single Laboratory template
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="main-content" class="site-main site-main--laboratory-single">

	<?php
	while ( have_posts() ) :
		the_post();

		get_template_part( 'template-parts/laboratories/laboratories-single', 'hero' );
		get_template_part( 'template-parts/laboratories/laboratories-single', 'profile' );
		get_template_part( 'template-parts/laboratories/laboratories-single', 'people' );
		get_template_part( 'template-parts/laboratories/laboratories-single', 'methods' );
		get_template_part( 'template-parts/laboratories/laboratories-single', 'equipment' );

	endwhile;
	?>

</main>

<?php get_footer(); ?>
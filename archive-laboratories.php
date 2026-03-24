<?php
/**
 * Archive template for Laboratories
 *
 * @package newinlife
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="main-content" class="site-main site-main--laboratories">

	<?php get_template_part( 'template-parts/laboratories/laboratories-archive', 'header' ); ?>

	<?php get_template_part( 'template-parts/laboratories/laboratories-archive', 'grid' ); ?>

</main>

<?php
get_footer();
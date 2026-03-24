<?php
/**
 * Archive template for Teams
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="main-content" class="site-main site-main--teams">

	<?php get_template_part( 'template-parts/teams/teams-archive', 'header' ); ?>

	<?php get_template_part( 'template-parts/teams/teams-archive', 'area-nav' ); ?>

	<?php get_template_part( 'template-parts/teams/teams-archive', 'sections' ); ?>

</main>

<?php
get_footer();
<?php
/**
 * Front Page template
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="main-content" class="site-main site-main--front">
	<?php get_template_part( 'template-parts/front/inlife-front', 'hero' ); ?>
	<?php get_template_part( 'template-parts/front/inlife-front', 'areas' ); ?>
	<?php get_template_part( 'template-parts/front/inlife-front', 'news' ); ?>
	<?php get_template_part( 'template-parts/front/inlife-front', 'business' ); ?>
	<?php get_template_part( 'template-parts/front/inlife-front', 'popielno' ); ?>
</main>

<?php
get_footer();
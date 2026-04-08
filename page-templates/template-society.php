<?php
/**
 * Template Name: Society
 * Template Post Type: page
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

get_header();

$container = function_exists( 'inlife_container_class' ) ? inlife_container_class() : 'container';

$context = [
	'post_id'   => get_the_ID(),
	'container' => $container,
];
?>

<main id="main-content" class="site-main site-main--society">
	<?php get_template_part( 'template-parts/society/society', 'hero', $context ); ?>
	<?php get_template_part( 'template-parts/society/society', 'science-for-you', $context ); ?>
	<?php get_template_part( 'template-parts/society/society', 'articles', $context ); ?>
	<?php get_template_part( 'template-parts/society/society', 'initiatives', $context ); ?>
	<?php get_template_part( 'template-parts/society/society', 'media', $context ); ?>
	<?php get_template_part( 'template-parts/society/society', 'meet-us', $context ); ?>
	<?php get_template_part( 'template-parts/society/society', 'schools', $context ); ?>
	<?php get_template_part( 'template-parts/society/society', 'cta', $context ); ?>
</main>

<?php
get_footer();
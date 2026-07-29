<?php
/**
 * Front Page template
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

get_header();

$is_polish_language = ! function_exists( 'pll_current_language' ) ||
	'pl' === (string) pll_current_language( 'slug' );
?>

<main id="main-content" class="site-main site-main--front">
	<?php get_template_part( 'template-parts/front/inlife-front', 'hero' ); ?>

	<?php if ( $is_polish_language ) : ?>
		<?php get_template_part( 'template-parts/global/funding-strip' ); ?>
	<?php endif; ?>
	
	<?php get_template_part( 'template-parts/front/inlife-front', 'areas' ); ?>
	<?php get_template_part( 'template-parts/front/inlife-front', 'news' ); ?>
	<?php get_template_part( 'template-parts/front/inlife-front', 'business' ); ?>
	<?php get_template_part( 'template-parts/front/inlife-front', 'popielno' ); ?>
</main>

<?php
get_footer();
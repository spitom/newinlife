<?php
defined( 'ABSPATH' ) || exit;

$home_url = home_url( '/' );
$site_name = get_bloginfo( 'name' );

$logo_desktop_pl = get_stylesheet_directory_uri() . '/assets/images/logo-InLife-PL.png';
$logo_desktop_en = get_stylesheet_directory_uri() . '/assets/images/logo-InLife-EN.png';

$logo_mobile_pl = get_stylesheet_directory_uri() . '/assets/images/InLife-logo-PL.png';
$logo_mobile_en = get_stylesheet_directory_uri() . '/assets/images/InLife-logo-EN.png';

$current_lang = function_exists( 'pll_current_language' )
	? pll_current_language( 'slug' )
	: 'pl';

$logo_desktop = ( 'en' === $current_lang ) ? $logo_desktop_en : $logo_desktop_pl;
$logo_mobile  = ( 'en' === $current_lang ) ? $logo_mobile_en : $logo_mobile_pl;

?>

<div class="site-branding">
	<a href="<?php echo esc_url( $home_url ); ?>" class="navbar-brand" rel="home">
		<picture>
			<source
				media="(min-width: 1200px)"
				srcset="<?php echo esc_url( $logo_desktop ); ?>"
			>
			<img
				src="<?php echo esc_url( $logo_mobile ); ?>"
				class="img-fluid custom-logo"
				alt=""
				decoding="async"
			>
		</picture>
		<span class="visually-hidden"><?php echo esc_html( $site_name ); ?></span>
	</a>
</div>
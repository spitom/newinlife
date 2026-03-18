<?php
defined( 'ABSPATH' ) || exit;

$home_url = home_url( '/' );
$site_name = get_bloginfo( 'name' );

$logo_pl = get_stylesheet_directory_uri() . '/assets/images/InLife-logo-PL.png';
$logo_en = get_stylesheet_directory_uri() . '/assets/images/InLife-logo-EN.png';

$current_lang = function_exists( 'pll_current_language' ) ? pll_current_language( 'slug' ) : 'pl';
$logo_src = ( 'en' === $current_lang ) ? $logo_en : $logo_pl;

$logo_alt = ( 'en' === $current_lang )
	? __( 'InLife Institute logo', 'newinlife-child' )
	: __( 'Logo Instytutu InLife', 'newinlife-child' );
?>

<div class="site-branding">
	<a href="<?php echo esc_url( $home_url ); ?>" class="navbar-brand" rel="home">
		<img
			src="<?php echo esc_url( $logo_src ); ?>"
			class="img-fluid custom-logo"
			alt="<?php echo esc_attr( $logo_alt ); ?>"
			decoding="async"
		>
		<span class="visually-hidden"><?php echo esc_html( $site_name ); ?></span>
	</a>
</div>
<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Understrap
 */

defined( 'ABSPATH' ) || exit;

$container    = get_theme_mod( 'understrap_container_type', 'container' );
$site_name    = get_bloginfo( 'name' );
$current_year = gmdate( 'Y' );
$home_url     = home_url( '/' );

/**
 * Footer logo
 */
$footer_logo_url = get_stylesheet_directory_uri() . '/assets/images/inlife-logo-footer.png';

/**
 * Footer contact data
 * Polylang string translation for language-dependent text.
 */
$footer_address_line_1_default = 'ul. Trylińskiego 18';
$footer_address_line_2_default = '10-683 Olsztyn, Polska';
$footer_description_default    = 'InLife rozwija wiedzę i tworzy innowacje w&nbsp;obszarach żywności, zdrowia i rozrodu dla&nbsp;dobra ludzi, zwierząt i&nbsp;środowiska.';

$footer_address_line_1 = function_exists( 'pll__' ) ? pll__( $footer_address_line_1_default ) : $footer_address_line_1_default;
$footer_address_line_2 = function_exists( 'pll__' ) ? pll__( $footer_address_line_2_default ) : $footer_address_line_2_default;
$footer_description    = function_exists( 'pll__' ) ? pll__( $footer_description_default ) : $footer_description_default;

$footer_phone = '+48 89 500 32 00';
$footer_email = 'instytut@pan.olsztyn.pl';
?>

<footer id="colophon" class="site-footer inlife-footer" aria-labelledby="footer-heading">
	<h2 id="footer-heading" class="visually-hidden">
		<?php esc_html_e( 'Stopka serwisu', 'understrap-child' ); ?>
	</h2>

	<div class="inlife-footer__main">
		<div class="<?php echo esc_attr( $container ); ?>">

			<div class="row gy-4 gy-lg-5">

				<div class="col-12 col-lg-4 inlife-footer__brand-col">
					<div class="inlife-footer__brand">
						<a class="inlife-footer__brand-link" href="<?php echo esc_url( $home_url ); ?>" aria-label="<?php echo esc_attr( $site_name ); ?>">
							<img
								class="inlife-footer__logo"
								src="<?php echo esc_url( $footer_logo_url ); ?>"
								alt="<?php echo esc_attr( $site_name ); ?>"
								loading="lazy"
							>
						</a>

						<div class="inlife-footer__intro">
							<p class="inlife-footer__description">
								<?php echo esc_html( $footer_description ); ?>
							</p>
						</div>
					</div>
				</div>

				<div class="col-12 col-md-4 col-lg-4 col-xl-3">
					<section class="inlife-footer__section" aria-labelledby="footer-contact-heading">
						<h3 id="footer-contact-heading" class="inlife-footer__title">
							<?php esc_html_e( 'Kontakt', 'understrap-child' ); ?>
						</h3>

						<address class="inlife-footer__address">
							<span><?php echo esc_html( $site_name ); ?></span><br>
							<span><?php echo esc_html( $footer_address_line_1 ); ?></span><br>
							<span><?php echo esc_html( $footer_address_line_2 ); ?></span>
						</address>

						<ul class="inlife-footer__list inlife-footer__list--contact list-unstyled">
							<li>
								<a href="<?php echo esc_url( 'tel:' . preg_replace( '/[^0-9+]/', '', $footer_phone ) ); ?>">
									<?php echo esc_html( $footer_phone ); ?>
								</a>
							</li>
							<li>
								<a href="<?php echo esc_url( 'mailto:' . antispambot( $footer_email ) ); ?>">
									<?php echo esc_html( antispambot( $footer_email ) ); ?>
								</a>
							</li>
						</ul>
					</section>
				</div>

				<div class="col-12 col-md-4 col-lg-4 col-xl-3">
					<nav class="inlife-footer__section" aria-labelledby="footer-employee-heading">
						<h3 id="footer-employee-heading" class="inlife-footer__title">
							<?php esc_html_e( 'Strefa pracownika', 'understrap-child' ); ?>
						</h3>

						<?php
						wp_nav_menu(
							[
								'theme_location' => 'footer_employee',
								'container'      => false,
								'menu_class'     => 'inlife-footer__list inlife-footer__list--employee list-unstyled',
								'fallback_cb'    => false,
								'depth'          => 1,
							]
						);
						?>
					</nav>
				</div>

				<div class="col-12 col-md-4 col-lg-3 col-xl-2">
					<nav class="inlife-footer__section" aria-labelledby="footer-info-heading">
						<h3 id="footer-info-heading" class="inlife-footer__title">
							<?php esc_html_e( 'Informacje', 'understrap-child' ); ?>
						</h3>

						<?php
						wp_nav_menu(
							[
								'theme_location' => 'footer_info',
								'container'      => false,
								'menu_class'     => 'inlife-footer__list list-unstyled',
								'fallback_cb'    => false,
								'depth'          => 1,
							]
						);
						?>
					</nav>
				</div>

			</div>

			<div class="row">
				<div class="col-12 col-xl-8 offset-xl-4">
					<div class="inlife-footer__utility">

						<div class="inlife-footer__utility-top">
							<div class="inlife-footer__social-wrap" aria-label="<?php esc_attr_e( 'Media społecznościowe', 'understrap-child' ); ?>">
								<?php
								wp_nav_menu(
									[
										'theme_location' => 'footer_social',
										'container'      => false,
										'menu_class'     => 'inlife-footer__social list-unstyled',
										'fallback_cb'    => false,
										'depth'          => 1,
									]
								);
								?>
							</div>
						</div>

						<div class="inlife-footer__utility-line" aria-hidden="true"></div>

						<div class="inlife-footer__utility-bottom">
							<p class="inlife-footer__copyright inlife-footer__copyright--bottom">
								&copy; <?php echo esc_html( $current_year ); ?> InLife
							</p>
						</div>

					</div>
				</div>
			</div>

		</div>
	</div>
</footer>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
<?php
/**
 * The template for displaying the footer.
 *
 * @package Understrap
 */

defined( 'ABSPATH' ) || exit;

$site_name    = get_bloginfo( 'name' );
$current_year = gmdate( 'Y' );
$home_url     = home_url( '/' );

$footer_logo_url = get_stylesheet_directory_uri() . '/assets/images/hr-excellence-in-research-footer.png';

$footer_description = function_exists( 'inlife_t' )
	? inlife_t( 'InLife wspiera rozwój naukowców i wysokie standardy pracy badawczej, rozwijając kulturę współpracy, mobilności i rozwoju kariery.' )
	: 'InLife wspiera rozwój naukowców i wysokie standardy pracy badawczej, rozwijając kulturę współpracy, mobilności i rozwoju kariery.';

$footer_address_line_1 = function_exists( 'inlife_t' )
	? inlife_t( 'ul. Trylińskiego 18' )
	: 'ul. Trylińskiego 18';

$footer_address_line_2 = function_exists( 'inlife_t' )
	? inlife_t( '10-683 Olsztyn, Polska' )
	: '10-683 Olsztyn, Polska';

$footer_phone = '+48 89 500 32 00';
$footer_email = 'instytut@pan.olsztyn.pl';
?>

<footer id="colophon" class="site-footer inlife-footer" aria-labelledby="footer-heading">
	<h2 id="footer-heading" class="visually-hidden">
		<?php echo esc_html( function_exists( 'inlife_t' ) ? inlife_t( 'Stopka serwisu' ) : 'Stopka serwisu' ); ?>
	</h2>

	<div class="inlife-footer__main">
		<div class="inlife-container">
			<div class="inlife-content">

				<div class="inlife-footer__grid">

					<div class="inlife-footer__brand-col">
						<div class="inlife-footer__brand">
							<div class="inlife-footer__brand-link" aria-hidden="true">
								<img
									class="inlife-footer__logo"
									src="<?php echo esc_url( $footer_logo_url ); ?>"
									alt="<?php echo esc_attr( $site_name ); ?>"
									loading="lazy"
								>
							</div>

							<p class="inlife-footer__description">
								<?php echo esc_html( $footer_description ); ?>
							</p>
						</div>
					</div>

					<section class="inlife-footer__section" aria-labelledby="footer-contact-heading">
						<h3 id="footer-contact-heading" class="inlife-footer__title">
							<?php echo esc_html( function_exists( 'inlife_t' ) ? inlife_t( 'Kontakt' ) : 'Kontakt' ); ?>
						</h3>

						<address class="inlife-footer__address">
							<span><?php echo esc_html( $site_name ); ?></span><br>
							<span><?php echo esc_html( $footer_address_line_1 ); ?></span><br>
							<span><?php echo esc_html( $footer_address_line_2 ); ?></span>
						</address>

						<ul class="inlife-footer__list inlife-footer__list--contact">
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

					<nav class="inlife-footer__section" aria-labelledby="footer-employee-heading">
						<h3 id="footer-employee-heading" class="inlife-footer__title">
							<?php echo esc_html( function_exists( 'inlife_t' ) ? inlife_t( 'Strefa pracownika' ) : 'Strefa pracownika' ); ?>
						</h3>

						<?php
						wp_nav_menu(
							[
								'theme_location' => 'footer_employee',
								'container'      => false,
								'menu_class'     => 'inlife-footer__list inlife-footer__list--employee',
								'fallback_cb'    => false,
								'depth'          => 1,
							]
						);
						?>
					</nav>

					<nav class="inlife-footer__section" aria-labelledby="footer-info-heading">
						<h3 id="footer-info-heading" class="inlife-footer__title">
							<?php echo esc_html( function_exists( 'inlife_t' ) ? inlife_t( 'Informacje' ) : 'Informacje' ); ?>
						</h3>

						<?php
						wp_nav_menu(
							[
								'theme_location' => 'footer_info',
								'container'      => false,
								'menu_class'     => 'inlife-footer__list',
								'fallback_cb'    => false,
								'depth'          => 1,
							]
						);
						?>
					</nav>

				</div>

				<div class="inlife-footer__utility">
					<div class="inlife-footer__utility-top">
						<nav class="inlife-footer__social-wrap" aria-label="<?php echo esc_attr( function_exists( 'inlife_t' ) ? inlife_t( 'Media społecznościowe' ) : 'Media społecznościowe' ); ?>">
							<?php
							wp_nav_menu(
								[
									'theme_location' => 'footer_social',
									'container'      => false,
									'menu_class'     => 'inlife-footer__social',
									'fallback_cb'    => false,
									'depth'          => 1,
								]
							);
							?>
						</nav>
					</div>

					<div class="inlife-footer__utility-line" aria-hidden="true"></div>

					<div class="inlife-footer__utility-bottom">
						<p class="inlife-footer__copyright inlife-footer__copyright--bottom">
							&copy; <?php echo esc_html( $current_year ); ?> <?php echo esc_html( $site_name ); ?>
						</p>
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
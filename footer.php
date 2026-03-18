<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$container    = get_theme_mod( 'understrap_container_type', 'container' );
$site_name    = get_bloginfo( 'name' );
$site_desc    = get_bloginfo( 'description' );
$current_year = gmdate( 'Y' );
$home_url     = home_url( '/' );
$privacy_url  = get_privacy_policy_url();

/**
 * Ścieżka / URL do białego logo w footerze.
 * Możesz tu podać np. plik z child theme:
 * get_stylesheet_directory_uri() . '/img/logo-footer-white.svg'
 */
$footer_logo_url = get_stylesheet_directory_uri() . '/assets/images/inlife-logo-footer.png';

/**
 * Footer contact data
 * Docelowo możesz to przepiąć do ACF Options / Customizer.
 */
$footer_address_line_1 = 'ul. Trylińskiego 18';
$footer_address_line_2 = '10-683 Olsztyn, Polska';
$footer_phone          = '+48 89 500 32 00';
$footer_email          = 'instytut@pan.olsztyn.pl';

/**
 * Kolumna 3 – Strefa pracownika
 */

wp_nav_menu(
	[
		'theme_location' => 'footer_employee',
		'container'      => false,
		'menu_class'     => 'inlife-footer__list inlife-footer__list--employee list-unstyled',
		'fallback_cb'    => false,
		'depth'          => 1,
	]
);


/**
 * Kolumna 4 – Informacje
 */
wp_nav_menu(
	[
		'theme_location' => 'footer_info',
		'container'      => false,
		'menu_class'     => 'inlife-footer__list list-unstyled',
		'fallback_cb'    => false,
		'depth'          => 1,
	]
);

/**
 * Social media with Bootstrap Icons.
 */
$wp_nav_menu(
	[
		'theme_location' => 'footer_social',
		'container'      => false,
		'menu_class'     => 'inlife-footer__social list-unstyled',
		'fallback_cb'    => false,
		'depth'          => 1,
	]
);
?>

<footer id="colophon" class="site-footer inlife-footer" aria-labelledby="footer-heading">
	<h2 id="footer-heading" class="visually-hidden">
		<?php esc_html_e( 'Stopka serwisu', 'understrap' ); ?>
	</h2>

	<div class="inlife-footer__main">
		<div class="<?php echo esc_attr( $container ); ?>">
			<div class="row gy-4 gy-lg-5">

				<div class="col-12 col-lg-4">
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
								<?php
								echo esc_html(
									$site_desc
										? $site_desc
										: __( 'InLife rozwija wiedzę i tworzy innowacje w&nbsp;obszarach żywności, zdrowia i rozrodu dla dobra ludzi, zwierząt i&nbsp;środowiska.', 'understrap' )
								);
								?>
							</p>
						</div>

					</div>
				</div>

				<div class="col-12 col-md-6 col-lg-3">
					<section class="inlife-footer__section" aria-labelledby="footer-contact-heading">
						<h3 id="footer-contact-heading" class="inlife-footer__title">
							<?php esc_html_e( 'Kontakt', 'understrap' ); ?>
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

				<div class="col-12 col-md-6 col-lg-3">
					<nav class="inlife-footer__section" aria-labelledby="footer-employee-heading">
						<h3 id="footer-employee-heading" class="inlife-footer__title">
							<?php esc_html_e( 'Strefa pracownika', 'understrap' ); ?>
						</h3>

						<ul class="inlife-footer__list inlife-footer__list--employee list-unstyled">
							<?php foreach ( $employee_zone_links as $item ) : ?>
								<?php if ( ! empty( $item['url'] ) && ! empty( $item['label'] ) ) : ?>
									<li>
										<a href="<?php echo esc_url( $item['url'] ); ?>">
											<?php echo esc_html( $item['label'] ); ?>
										</a>
									</li>
								<?php endif; ?>
							<?php endforeach; ?>
						</ul>
					</nav>
				</div>

				<div class="col-12 col-md-6 col-lg-2">
					<nav class="inlife-footer__section" aria-labelledby="footer-info-heading">
						<h3 id="footer-info-heading" class="inlife-footer__title">
							<?php esc_html_e( 'Informacje', 'understrap' ); ?>
						</h3>

						<ul class="inlife-footer__list list-unstyled">
							<?php foreach ( $footer_formal_links as $item ) : ?>
								<?php if ( ! empty( $item['url'] ) && ! empty( $item['label'] ) ) : ?>
									<?php $is_external = strpos( $item['url'], home_url() ) === false; ?>
									<li>
										<a
											href="<?php echo esc_url( $item['url'] ); ?>"
											<?php echo $is_external ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>
										>
											<?php echo esc_html( $item['label'] ); ?>
											<?php if ( $is_external ) : ?>
												<span class="visually-hidden">
													<?php esc_html_e( ' (otwiera się w nowej karcie)', 'understrap' ); ?>
												</span>
											<?php endif; ?>
										</a>
									</li>
								<?php endif; ?>
							<?php endforeach; ?>
						</ul>
					</nav>
				</div>

			</div>

			<div class="row">
				<div class="col-12 offset-lg-4 col-lg-8">
					<div class="inlife-footer__utility">
						<div class="inlife-footer__utility-top">
							<div class="inlife-footer__social-wrap" aria-label="<?php esc_attr_e( 'Media społecznościowe', 'understrap' ); ?>">
								<ul class="inlife-footer__social list-unstyled">
									<?php foreach ( $footer_social_links as $item ) : ?>
										<?php if ( ! empty( $item['url'] ) && ! empty( $item['label'] ) && ! empty( $item['icon'] ) ) : ?>
											<li>
												<a
													href="<?php echo esc_url( $item['url'] ); ?>"
													target="_blank"
													rel="noopener noreferrer"
													aria-label="<?php echo esc_attr( $item['label'] ); ?>"
												>
													<i class="<?php echo esc_attr( $item['icon'] ); ?>" aria-hidden="true"></i>
													<span class="visually-hidden"><?php echo esc_html( $item['label'] ); ?></span>
												</a>
											</li>
										<?php endif; ?>
									<?php endforeach; ?>
								</ul>
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

<?php // Closing div#page from header.php. ?>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
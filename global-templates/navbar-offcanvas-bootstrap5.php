<?php
/**
 * Header Navbar (bootstrap5) - InLife custom offcanvas
 *
 * @package Understrap
 */

defined( 'ABSPATH' ) || exit;

$container = inlife_container_class();
?>

<header id="wrapper-navbar" class="site-header">

	<a class="skip-link visually-hidden-focusable" href="#main-content">
		<?php esc_html_e( 'Przejdź do treści', 'newinlife-child' ); ?>
	</a>

	<?php get_template_part( 'template-parts/header/inlife', 'topbar' ); ?>

	<nav id="main-nav" class="navbar navbar-inlife" aria-labelledby="main-nav-label">
		<h2 id="main-nav-label" class="visually-hidden">
			<?php esc_html_e( 'Główna nawigacja', 'newinlife-child' ); ?>
		</h2>

		<div class="<?php echo esc_attr( $container ); ?>">
			<div class="navbar-main-wrap">

				<div class="navbar-brand-wrap">
					<?php get_template_part( 'template-parts/header/inlife', 'branding' ); ?>
				</div>

				<nav class="main-nav-desktop d-none d-xl-flex" aria-label="<?php esc_attr_e( 'Główna nawigacja', 'newinlife-child' ); ?>">
					<?php
					wp_nav_menu([
						'theme_location' => 'primary',
						'container'      => false,
						'menu_class'     => 'navbar-nav ms-auto inlife-primary-nav',
						'fallback_cb'    => false,
						'depth'          => 3,
						'walker'         => new Inlife_Accessible_Navwalker(),
					]);
					?>
				</nav>

				<div class="mobile-header-tools d-flex d-xl-none align-items-center">
					<div class="mobile-bip-link">
						<?php get_template_part( 'template-parts/header/inlife', 'bip-link' ); ?>
					</div>
					<div class="mobile-lang-switcher">
						<?php get_template_part( 'template-parts/header/inlife', 'language-switcher-mobile' ); ?>
					</div>

					<button
						class="navbar-toggler"
						type="button"
						data-bs-toggle="offcanvas"
						data-bs-target="#navbarNavOffcanvas"
						aria-controls="navbarNavOffcanvas"
						aria-expanded="false"
						aria-label="<?php esc_attr_e( 'Otwórz menu', 'newinlife-child' ); ?>"
					>
						<span class="inlife-burger" aria-hidden="true">
							<span></span>
							<span></span>
							<span></span>
						</span>
					</button>
				</div>

			</div>
		</div>
	</nav>

</header>

<div
	class="offcanvas offcanvas-end offcanvas-inlife"
	tabindex="-1"
	id="navbarNavOffcanvas"
	aria-labelledby="navbarNavOffcanvasLabel"
>
	<div class="offcanvas-header">
		<h2 id="navbarNavOffcanvasLabel" class="offcanvas-title h5 mb-0">
			<?php esc_html_e( 'Menu', 'newinlife-child' ); ?>
		</h2>

		<button
			class="btn-close btn-close-white"
			type="button"
			data-bs-dismiss="offcanvas"
			aria-label="<?php esc_attr_e( 'Zamknij menu', 'newinlife-child' ); ?>"
		></button>
	</div>

	<div class="offcanvas-body">
		<?php get_template_part( 'template-parts/header/inlife', 'mobile-search' ); ?>

		<?php
		wp_nav_menu(
			array(
				'theme_location'       => 'top',
				'container'            => 'nav',
				'container_class'      => 'offcanvas-utility-nav',
				'container_aria_label' => esc_attr__( 'Menu użytkowe', 'newinlife-child' ),
				'menu_class'           => 'navbar-nav offcanvas-utility-menu',
				'fallback_cb'          => false,
				'menu_id'              => 'offcanvas-top-menu',
				'depth'                => 1,
			)
		);
		?>

		<hr class="offcanvas-divider">

		<?php
		wp_nav_menu(
			array(
				'theme_location'       => 'primary',
				'container'            => 'nav',
				'container_class'      => 'offcanvas-primary-nav',
				'container_aria_label' => esc_attr__( 'Główna nawigacja', 'newinlife-child' ),
				'menu_class'           => 'navbar-nav offcanvas-primary-menu',
				'fallback_cb'          => false,
				'menu_id'              => 'offcanvas-main-menu',
				'depth'                => 2,
				'walker'         	   => new Inlife_Accessible_Navwalker(),
			)
		);
		?>
	</div>
</div>
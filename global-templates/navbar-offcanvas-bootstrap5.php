<?php
/**
 * Header Navbar (bootstrap5) - InLife custom offcanvas
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$container = inlife_container_class();
?>

<header id="wrapper-navbar" class="site-header">

	<a class="skip-link visually-hidden-focusable" href="#main-content">
		<?php esc_html_e( 'Przejdź do treści', 'newinlife-child' ); ?>
	</a>

	<?php get_template_part( 'template-parts/header/inlife', 'topbar' ); ?>

	<nav id="main-nav" class="navbar navbar-expand-xl navbar-inlife" aria-labelledby="main-nav-label">
		<h2 id="main-nav-label" class="visually-hidden">
			<?php esc_html_e( 'Główna nawigacja', 'newinlife-child' ); ?>
		</h2>

		<div class="<?php echo esc_attr( $container ); ?>">
			<div class="navbar-main-wrap d-flex align-items-center justify-content-between w-100">

				<div class="navbar-brand-wrap">
					<?php get_template_part( 'template-parts/header/inlife', 'branding' ); ?>
				</div>

				<div class="d-none d-xl-flex align-items-center ms-auto">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'container'      => false,
							'menu_class'     => 'navbar-nav main-menu-desktop align-items-xl-center',
							'fallback_cb'    => false,
							'menu_id'        => 'main-menu',
							'depth'          => 2,
							'walker'         => new Understrap_WP_Bootstrap_Navwalker(),
						)
					);
					?>
				</div>

				<button
					class="navbar-toggler d-xl-none"
					type="button"
					data-bs-toggle="offcanvas"
					data-bs-target="#navbarNavOffcanvas"
					aria-controls="navbarNavOffcanvas"
					aria-expanded="false"
					aria-label="<?php esc_attr_e( 'Otwórz menu', 'newinlife-child' ); ?>"
				>
					<span class="navbar-toggler-icon" aria-hidden="true"></span>
				</button>
			</div>

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
					<?php
					wp_nav_menu(
						array(
							'theme_location'       => 'top',
							'container'            => 'nav',
							'container_class'      => 'offcanvas-utility-nav mb-4',
							'container_aria_label' => esc_attr__( 'Menu użytkowe', 'newinlife-child' ),
							'menu_class'           => 'navbar-nav offcanvas-utility-menu',
							'fallback_cb'          => false,
							'menu_id'              => 'offcanvas-top-menu',
							'depth'                => 1,
						)
					);
					?>

					<?php get_template_part( 'template-parts/header/inlife', 'language-switcher' ); ?>

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
							'walker'               => new Understrap_WP_Bootstrap_Navwalker(),
						)
					);
					?>
				</div>
			</div>
		</div>
	</nav>

</header>
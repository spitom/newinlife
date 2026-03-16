<?php
defined( 'ABSPATH' ) || exit;

$container = inlife_container_class();
?>

<div class="header-topbar d-none d-xl-block" aria-label="<?php esc_attr_e( 'Górne menu użytkowe', 'newinlife-child' ); ?>">
	<div class="<?php echo esc_attr( $container ); ?>">
		<div class="header-topbar__inner d-flex align-items-center justify-content-end gap-4">

			<?php
			wp_nav_menu(
				array(
					'theme_location'       => 'top',
					'container'            => 'nav',
					'container_class'      => 'topbar-nav',
					'container_aria_label' => esc_attr__( 'Menu użytkowe', 'newinlife-child' ),
					'menu_class'           => 'topbar-menu list-unstyled d-flex align-items-center gap-3 mb-0',
					'fallback_cb'          => false,
					'menu_id'              => 'topbar-menu',
					'depth'                => 1,
				)
			);
			?>

			<?php get_template_part( 'template-parts/header/inlife', 'language-switcher' ); ?>

		</div>
	</div>
</div>
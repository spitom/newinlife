<?php
defined( 'ABSPATH' ) || exit;

$container = inlife_container_class();
?>

<div class="header-topbar d-none d-xl-block" aria-label="<?php esc_attr_e( 'Górne menu użytkowe', 'newinlife-child' ); ?>">
	<div class="<?php echo esc_attr( $container ); ?>">
		<div class="header-topbar__inner">

			<div class="topbar-tools">
				<?php get_template_part( 'template-parts/header/inlife', 'search-toggle' ); ?>
			</div>

			<?php
			wp_nav_menu(
				array(
					'theme_location'       => 'top',
					'container'            => 'nav',
					'container_class'      => 'topbar-nav',
					'container_aria_label' => esc_attr__( 'Menu użytkowe', 'newinlife-child' ),
					'menu_class'           => 'topbar-menu',
					'fallback_cb'          => false,
					'menu_id'              => 'topbar-menu',
					'depth'                => 1,
				)
			);
			?>

			<div class="topbar-bip">
				<?php get_template_part( 'template-parts/header/inlife', 'bip-link' ); ?>
			</div>

			<div class="topbar-lang">
				<?php get_template_part( 'template-parts/header/inlife', 'language-switcher' ); ?>
			</div>

		</div>
	</div>
</div>

<?php get_template_part( 'template-parts/header/inlife', 'search-panel' ); ?>
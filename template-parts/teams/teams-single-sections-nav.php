<?php
defined( 'ABSPATH' ) || exit;

$valid_panels = array( 'badania', 'projekty', 'publikacje', 'aktualnosci' );
$active_panel = isset( $_GET['team_section'] ) ? sanitize_key( wp_unslash( $_GET['team_section'] ) ) : 'badania';

if ( ! in_array( $active_panel, $valid_panels, true ) ) {
	$active_panel = 'badania';
}

$tabs = array(
	'badania'    => inlife_t( 'Osiągnięcia naukowe' ),
	'projekty'   => inlife_t( 'Aktualne projekty' ),
	'publikacje' => inlife_t( 'Publikacje' ),
	'aktualnosci'=> inlife_t( 'Aktualności' ),
);
?>

<div class="team-sections-nav-wrap">
	<header class="section-heading">
		<p class="section-kicker"><?php echo esc_html( inlife_t( 'Dorobek i aktywność zespołu' ) ); ?></p>
		<h2 class="section-title"><?php echo esc_html( inlife_t( 'Szczegóły działalności' ) ); ?></h2>
	</header>

	<nav
		class="team-sections-nav c-pills"
		aria-label="<?php echo esc_attr( inlife_t( 'Nawigacja sekcji zespołu' ) ); ?>"
		role="tablist"
	>
		<?php foreach ( $tabs as $panel_key => $panel_label ) : ?>
			<?php $is_active = ( $panel_key === $active_panel ); ?>
			<button
				type="button"
				id="team-tab-<?php echo esc_attr( $panel_key ); ?>"
				class="team-sections-nav__btn c-pill<?php echo $is_active ? ' is-active' : ''; ?>"
				data-team-panel-trigger="<?php echo esc_attr( $panel_key ); ?>"
				role="tab"
				aria-controls="team-panel-<?php echo esc_attr( $panel_key ); ?>"
				aria-selected="<?php echo $is_active ? 'true' : 'false'; ?>"
				tabindex="<?php echo $is_active ? '0' : '-1'; ?>"
			>
				<?php echo esc_html( $panel_label ); ?>
			</button>
		<?php endforeach; ?>
	</nav>
</div>
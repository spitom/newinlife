<?php
defined( 'ABSPATH' ) || exit;

$valid_panels = array( 'badania', 'projekty', 'publikacje', 'aktualnosci' );
$active_panel = isset( $_GET['team_section'] ) ? sanitize_key( wp_unslash( $_GET['team_section'] ) ) : 'badania';

if ( ! in_array( $active_panel, $valid_panels, true ) ) {
	$active_panel = 'badania';
}

$panel_templates = array(
	'badania'     => 'research',
	'projekty'    => 'projects',
	'publikacje'  => 'publications',
	'aktualnosci' => 'news',
);
?>

<div class="team-sections-panel" data-team-panels>
	<?php foreach ( $panel_templates as $panel_key => $template_slug ) : ?>
		<?php $is_active = ( $panel_key === $active_panel ); ?>
		<section
			id="team-panel-<?php echo esc_attr( $panel_key ); ?>"
			class="team-sections-panel__item<?php echo $is_active ? ' is-active' : ''; ?>"
			data-team-panel-content="<?php echo esc_attr( $panel_key ); ?>"
			role="tabpanel"
			aria-labelledby="team-tab-<?php echo esc_attr( $panel_key ); ?>"
			tabindex="0"
			<?php echo $is_active ? '' : 'hidden'; ?>
		>
			<?php get_template_part( 'template-parts/teams/teams-single-section', $template_slug ); ?>
		</section>
	<?php endforeach; ?>
</div>
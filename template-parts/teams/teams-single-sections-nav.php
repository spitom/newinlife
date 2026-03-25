<?php
defined( 'ABSPATH' ) || exit;
?>

<div class="team-sections-nav-wrap">
	<header class="section-heading">
		<p class="section-kicker"><?php esc_html_e( 'Dorobek i aktywność zespołu', 'newinlife' ); ?></p>
		<h2 class="section-title"><?php esc_html_e( 'Szczegóły działalności', 'newinlife' ); ?></h2>
	</header>

	<nav class="team-sections-nav" aria-label="<?php esc_attr_e( 'Nawigacja sekcji zespołu', 'newinlife' ); ?>">
		<button
			type="button"
			class="team-sections-nav__btn is-active"
			data-team-panel-trigger="badania"
			aria-controls="team-panel-badania"
			aria-selected="true"
		>
			<?php esc_html_e( 'Badania', 'newinlife' ); ?>
		</button>

		<button
			type="button"
			class="team-sections-nav__btn"
			data-team-panel-trigger="projekty"
			aria-controls="team-panel-projekty"
			aria-selected="false"
		>
			<?php esc_html_e( 'Aktualne projekty', 'newinlife' ); ?>
		</button>

		<button
			type="button"
			class="team-sections-nav__btn"
			data-team-panel-trigger="publikacje"
			aria-controls="team-panel-publikacje"
			aria-selected="false"
		>
			<?php esc_html_e( 'Publikacje', 'newinlife' ); ?>
		</button>

		<button
			type="button"
			class="team-sections-nav__btn"
			data-team-panel-trigger="aktualnosci"
			aria-controls="team-panel-aktualnosci"
			aria-selected="false"
		>
			<?php esc_html_e( 'Aktualności', 'newinlife' ); ?>
		</button>
	</nav>
</div>
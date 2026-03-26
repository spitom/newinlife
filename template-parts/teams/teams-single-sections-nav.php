<?php
defined( 'ABSPATH' ) || exit;
?>

<div class="team-sections-nav-wrap">
	<header class="section-heading">
		<p class="section-kicker"><?php echo esc_html( inlife_t( 'Dorobek i aktywność zespołu' ) ); ?></p>
		<h2 class="section-title"><?php echo esc_html( inlife_t( 'Szczegóły działalności' ) ); ?></h2>
	</header>

	<nav class="team-sections-nav" aria-label="<?php echo esc_attr( inlife_t( 'Nawigacja sekcji zespołu' ) ); ?>">
		<button
			type="button"
			class="team-sections-nav__btn is-active"
			data-team-panel-trigger="badania"
			aria-controls="team-panel-badania"
			aria-selected="true"
		>
			<?php echo esc_html( inlife_t( 'Osiągnięcia naukowe' ) ); ?>
		</button>

		<button
			type="button"
			class="team-sections-nav__btn"
			data-team-panel-trigger="projekty"
			aria-controls="team-panel-projekty"
			aria-selected="false"
		>
			<?php echo esc_html( inlife_t( 'Aktualne projekty' ) ); ?>
		</button>

		<button
			type="button"
			class="team-sections-nav__btn"
			data-team-panel-trigger="publikacje"
			aria-controls="team-panel-publikacje"
			aria-selected="false"
		>
			<?php echo esc_html( inlife_t( 'Publikacje' ) ); ?>
		</button>

		<button
			type="button"
			class="team-sections-nav__btn"
			data-team-panel-trigger="aktualnosci"
			aria-controls="team-panel-aktualnosci"
			aria-selected="false"
		>
			<?php echo esc_html( inlife_t( 'Aktualności' ) ); ?>
		</button>
	</nav>
</div>
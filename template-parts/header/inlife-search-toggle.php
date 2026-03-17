<?php
defined( 'ABSPATH' ) || exit;
?>

<button
	type="button"
	class="topbar-search-toggle"
	data-inlife-search-toggle
	aria-expanded="false"
	aria-controls="inlife-search-panel"
	aria-label="<?php esc_attr_e( 'Otwórz wyszukiwarkę', 'newinlife-child' ); ?>"
>
	<span class="topbar-search-toggle__icon" aria-hidden="true">
		<svg viewBox="0 0 24 24" width="20" height="20" xmlns="http://www.w3.org/2000/svg" fill="none">
			<circle cx="11" cy="11" r="6.5" stroke="currentColor" stroke-width="2"></circle>
			<path d="M16 16L21 21" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
		</svg>
	</span>
	<span class="visually-hidden"><?php esc_html_e( 'Szukaj', 'newinlife-child' ); ?></span>
</button>
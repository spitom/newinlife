<?php
defined( 'ABSPATH' ) || exit;
?>

<div class="offcanvas-search">
	<form role="search" method="get" class="offcanvas-search__form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<label class="visually-hidden" for="offcanvas-search-field">
			<?php esc_html_e( 'Szukaj w serwisie', 'newinlife-child' ); ?>
		</label>

		<input
			type="search"
			id="offcanvas-search-field"
			class="offcanvas-search__input"
			name="s"
			value="<?php echo esc_attr( get_search_query() ); ?>"
			placeholder="<?php esc_attr_e( 'Szukaj…', 'newinlife-child' ); ?>"
			autocomplete="off"
		>

		<button
			type="submit"
			class="offcanvas-search__submit"
			aria-label="<?php esc_attr_e( 'Wyszukaj', 'newinlife-child' ); ?>"
		>
			<span class="offcanvas-search__icon" aria-hidden="true"></span>
		</button>
	</form>
</div>
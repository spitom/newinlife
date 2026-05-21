<?php
/**
 * Search form.
 *
 * @package newinlife-child
 */

defined( 'ABSPATH' ) || exit;

$search_query = get_search_query();
?>

<form role="search" method="get" class="c-search inlife-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="visually-hidden" for="search-form-field">
		<?php echo esc_html( inlife_t( 'Szukaj w serwisie' ) ); ?>
	</label>

	<div class="c-search__layout">
		<input
			id="search-form-field"
			class="c-search__input"
			type="search"
			name="s"
			value="<?php echo esc_attr( $search_query ); ?>"
			placeholder="<?php echo esc_attr( inlife_t( 'Wpisz szukaną frazę' ) ); ?>"
		>

		<button class="c-search__button" type="submit">
			<?php echo esc_html( inlife_t( 'Szukaj' ) ); ?>
		</button>
	</div>
</form>
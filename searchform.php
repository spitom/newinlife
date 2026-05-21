<?php
/**
 * Search form.
 *
 * @package newinlife-child
 */

defined( 'ABSPATH' ) || exit;

$search_query = get_search_query();
?>

<form role="search" method="get" class="inlife-site-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="visually-hidden" for="site-search-field">
		<?php echo esc_html( inlife_t( 'Szukaj w serwisie' ) ); ?>
	</label>

	<div class="inlife-site-search__grid">
		<input
			id="site-search-field"
			class="inlife-site-search__input"
			type="search"
			name="s"
			value="<?php echo esc_attr( $search_query ); ?>"
			placeholder="<?php echo esc_attr( inlife_t( 'Wpisz szukaną frazę' ) ); ?>"
		>

		<button class="inlife-site-search__submit" type="submit">
			<span><?php echo esc_html( inlife_t( 'Szukaj' ) ); ?></span>
			<span class="inlife-site-search__submit-icon" aria-hidden="true">→</span>
		</button>
	</div>
</form>
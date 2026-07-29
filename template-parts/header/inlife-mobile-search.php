<?php
defined( 'ABSPATH' ) || exit;
?>

<div class="offcanvas-search">

	<?php
	$site_url = trailingslashit( (string) get_option( 'home' ) );

	$current_language = function_exists( 'pll_current_language' )
		? (string) pll_current_language( 'slug' )
		: '';

	$default_language = function_exists( 'pll_default_language' )
		? (string) pll_default_language( 'slug' )
		: '';

	$search_action = $site_url;

	if (
		'' !== $current_language &&
		$current_language !== $default_language
	) {
		$search_action = trailingslashit(
			$site_url . $current_language
		);
	}
	?>

	<form role="search"
	      method="get"
		  class="offcanvas-search__form c-search"
		  action="<?php echo esc_url( $search_action ); ?>"
	>		

		<label class="visually-hidden" for="offcanvas-search-field">
			<?php echo esc_html( inlife_t( 'Szukaj w serwisie' ) ); ?>
		</label>

		<div class="offcanvas-search__grid c-search__inner">
			<input
				type="search"
				id="offcanvas-search-field"
				class="offcanvas-search__input c-search__input"
				name="s"
				value="<?php echo esc_attr( get_search_query() ); ?>"
				placeholder="<?php echo esc_attr( inlife_t( 'Wpisz szukaną frazę' ) ); ?>"
				autocomplete="off"
			>

			<button
				type="submit"
				class="offcanvas-search__submit c-search__button"
				aria-label="<?php echo esc_html( inlife_t( 'Szukaj' ) ); ?>"
			>
				<span class="offcanvas-search__icon" aria-hidden="true"></span>
			</button>
		</div>
	</form>
</div>
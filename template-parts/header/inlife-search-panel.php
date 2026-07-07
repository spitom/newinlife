<?php
defined( 'ABSPATH' ) || exit;

$container = inlife_container_class();
?>

<div id="inlife-search-panel" class="inlife-search-panel" hidden>
	<div class="<?php echo esc_attr( $container ); ?>">
		<div class="inlife-search-panel__inner">

			<form
				role="search"
				method="get"
				class="inlife-search-form c-search"
				action="<?php echo esc_url( function_exists( 'pll_home_url' ) ? pll_home_url() : home_url( '/' ) ); ?>"
			>
				

				<label class="visually-hidden" for="inlife-search-field">
					<?php echo esc_html( inlife_t( 'Szukaj w serwisie' ) ); ?>
				</label>

				<div class="inlife-search-form__layout">
					<div class="inlife-search-form__main c-search__inner">
						<input
							type="search"
							id="inlife-search-field"
							class="inlife-search-form__input c-search__input"
							name="s"
							value="<?php echo esc_attr( get_search_query() ); ?>"
							placeholder="<?php echo esc_attr( inlife_t( 'Wpisz szukaną frazę' ) ); ?>"
						>

						<button type="submit" class="btn btn-primary inlife-search-form__submit c-search__button">
							<?php echo esc_html( inlife_t( 'Szukaj' ) ); ?>
						</button>
					</div>

					<button
						type="button"
						class="inlife-search-form__close"
						data-inlife-search-close
						aria-label="<?php esc_attr_e( 'Zamknij wyszukiwarkę', 'newinlife-child' ); ?>"
					>
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			</form>
		</div>
	</div>
</div>
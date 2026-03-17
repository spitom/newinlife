<?php
defined( 'ABSPATH' ) || exit;

$container = inlife_container_class();
?>

<div id="inlife-search-panel" class="inlife-search-panel" hidden>
	<div class="<?php echo esc_attr( $container ); ?>">
		<div class="inlife-search-panel__inner">
			<form role="search" method="get" class="inlife-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<label class="visually-hidden" for="inlife-search-field">
					<?php esc_html_e( 'Szukaj w serwisie', 'newinlife-child' ); ?>
				</label>

				<input
					type="search"
					id="inlife-search-field"
					class="inlife-search-form__input"
					name="s"
					value="<?php echo esc_attr( get_search_query() ); ?>"
					placeholder="<?php esc_attr_e( 'Wpisz szukaną frazę…', 'newinlife-child' ); ?>"
				>

				<button type="submit" class="btn btn-primary inlife-search-form__submit">
					<?php esc_html_e( 'Szukaj', 'newinlife-child' ); ?>
				</button>

				<button
					type="button"
					class="inlife-search-form__close"
					data-inlife-search-close
					aria-label="<?php esc_attr_e( 'Zamknij wyszukiwarkę', 'newinlife-child' ); ?>"
				>
					<span aria-hidden="true">&times;</span>
				</button>
			</form>
		</div>
	</div>
</div>
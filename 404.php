<?php
/**
 * Custom 404 page.
 *
 * @package newinlife-child
 */

defined( 'ABSPATH' ) || exit;

get_header();

$container = function_exists( 'inlife_container_class' )
	? inlife_container_class()
	: 'container';

$home_url = function_exists( 'pll_home_url' )
	? (string) pll_home_url()
	: home_url( '/' );
?>

<main id="main-content" class="site-main site-main--404">

	<section class="page-section error-page">
		<div class="<?php echo esc_attr( $container ); ?>">

			<div class="error-page__surface">

				<div class="error-page__content">

					<p class="error-page__kicker">
						<?php echo esc_html( inlife_t( 'Błąd 404' ) ); ?>
					</p>

					<h1 class="error-page__title">
						<?php echo esc_html( inlife_t( 'Nie znaleźliśmy tej strony' ) ); ?>
					</h1>

					<p class="error-page__lead">
						<?php
						echo esc_html(
							inlife_t(
								'Adres może być nieprawidłowy albo strona została przeniesiona. Skorzystaj z wyszukiwarki lub wróć do strony głównej.'
							)
						);
						?>
					</p>

					<form
						role="search"
						method="get"
						class="error-page__search c-search"
						action="<?php echo esc_url( $home_url ); ?>"
					>
						<label
							class="visually-hidden"
							for="error-page-search-field"
						>
							<?php echo esc_html( inlife_t( 'Szukaj w serwisie' ) ); ?>
						</label>

						<div class="c-search__inner">
							<input
								type="search"
								id="error-page-search-field"
								class="c-search__input"
								name="s"
								placeholder="<?php echo esc_attr( inlife_t( 'Wpisz szukaną frazę' ) ); ?>"
							>

							<button
								type="submit"
								class="btn btn-primary c-search__button"
							>
								<?php echo esc_html( inlife_t( 'Szukaj' ) ); ?>
							</button>
						</div>
					</form>

					<div class="error-page__actions">
						<a
							class="btn btn-outline-primary"
							href="<?php echo esc_url( $home_url ); ?>"
						>
							<?php echo esc_html( inlife_t( 'Wróć do strony głównej' ) ); ?>
						</a>
					</div>

				</div>

				<div class="error-page__visual" aria-hidden="true">
					<span>404</span>
				</div>

			</div>

		</div>
	</section>

</main>

<?php
get_footer();
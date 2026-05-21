<?php
/**
 * Search results template.
 *
 * @package newinlife-child
 */

defined( 'ABSPATH' ) || exit;

get_header();

$container    = function_exists( 'inlife_container_class' ) ? inlife_container_class() : 'container';
$search_query = get_search_query();
$result_count = (int) $wp_query->found_posts;

?>

<main id="main" class="site-main site-main--search">

	<section class="page-section page-section--search-hero">
		<div class="<?php echo esc_attr( $container ); ?>">
			<?php
			get_template_part(
				'template-parts/patterns/pattern-page-hero',
				null,
				[
					'kicker'       => inlife_t( 'Wyszukiwarka' ),
					'title'        => $search_query
						? sprintf( inlife_t( 'Wyniki wyszukiwania dla: %s' ), $search_query )
						: inlife_t( 'Wyniki wyszukiwania' ),
					'lead'         => sprintf(
						inlife_t( 'Znaleziono %d wyników w serwisie InLife.' ),
						$result_count
					),
					'modifier'    => 'flush',
				]
			);
			?>
		</div>
	</section>

	<section class="page-section page-section--search-results">
		<div class="<?php echo esc_attr( $container ); ?>">
			<div class="p-page-hero__inner search-page">

				<?php if ( have_posts() ) : ?>
					<div class="search-results-list" aria-label="<?php echo esc_attr( inlife_t( 'Lista wyników wyszukiwania' ) ); ?>">
						<?php
						while ( have_posts() ) :
							the_post();

							get_template_part(
								'template-parts/search/search-result',
								null,
								[
									'post_id' => get_the_ID(),
								]
							);
						endwhile;
						?>
					</div>

					<?php
					the_posts_pagination(
						[
							'mid_size'           => 1,
							'prev_text'          => '←',
							'next_text'          => '→',
							'screen_reader_text' => inlife_t( 'Nawigacja po wynikach' ),
						]
					);					
					?>

				<?php else : ?>

					<div class="search-empty c-surface c-surface--panel">
						<h2 class="search-empty__title">
							<?php echo esc_html( inlife_t( 'Brak wyników' ) ); ?>
						</h2>
						<p class="search-empty__text">
							<?php echo esc_html( inlife_t( 'Spróbuj wpisać inną frazę lub użyć krótszego zapytania.' ) ); ?>
						</p>
					</div>

				<?php endif; ?>

			</div>
		</div>
	</section>

</main>

<?php
get_footer();
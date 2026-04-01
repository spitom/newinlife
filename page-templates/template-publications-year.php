<?php
/**
 * Template Name: Publications Year
 *
 * @package newinlife-child
 */

defined( 'ABSPATH' ) || exit;

get_header();

$container    = function_exists( 'inlife_container_class' ) ? inlife_container_class() : 'container';
$current_year = function_exists( 'inlife_get_publication_year_from_page_title' ) ? inlife_get_publication_year_from_page_title() : '';
$items        = function_exists( 'inlife_get_publications_by_year' ) ? inlife_get_publications_by_year( $current_year ) : array();
?>

<main id="main-content" class="site-main site-main--landing site-main--publications-year">

	<?php
	get_template_part(
		'template-parts/page/page',
		'hero-inner',
		array(
			'eyebrow' => function_exists( 'inlife_t' ) ? inlife_t( 'Publikacje' ) : __( 'Publikacje', 'newinlife-child' ),
			'title'   => $current_year ? $current_year : get_the_title(),
		)
	);
	?>

	<section class="page-section page-section--publications-year-intro" aria-labelledby="publications-year-intro-heading">
		<div class="<?php echo esc_attr( $container ); ?>">
			<div class="publications-year-intro">
				<div class="row">
					<div class="col-xl-10">
						<h2 id="publications-year-intro-heading" class="visually-hidden">
							<?php echo esc_html( function_exists( 'inlife_t' ) ? inlife_t( 'Wprowadzenie do publikacji rocznych' ) : __( 'Wprowadzenie do publikacji rocznych', 'newinlife-child' ) ); ?>
						</h2>

						<p class="publications-year-intro__lead">
							<?php
							if ( $current_year ) {
								printf(
									esc_html(
										function_exists( 'inlife_t' )
											? inlife_t( 'Lista publikacji naukowych z roku %s.' )
											: __( 'Lista publikacji naukowych z roku %s.', 'newinlife-child' )
									),
									esc_html( $current_year )
								);
							}
							?>
						</p>

						<p class="publications-year-intro__back mb-0">
							<a href="<?php echo esc_url( function_exists( 'pll_home_url' ) ? trailingslashit( pll_home_url() ) . ( 'en' === pll_current_language() ? 'publications/' : 'badania/publikacje/' ) : home_url( 'badania/publikacje/' ) ); ?>">
								<?php
								echo esc_html(
									function_exists( 'inlife_t' )
										? inlife_t( 'Wróć do listy lat' )
										: __( 'Wróć do listy lat', 'newinlife-child' )
								);
								?>
							</a>
						</p>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="page-section page-section--publications-list" aria-labelledby="publications-list-heading">
		<div class="<?php echo esc_attr( $container ); ?>">
			<div class="publications-year-list-wrap">
				<div class="row">
					<div class="col-xl-11">
						<h2 id="publications-list-heading" class="publications-year-list-wrap__heading">
							<?php echo esc_html( $current_year ? $current_year : get_the_title() ); ?>
						</h2>

						<?php if ( ! empty( $items ) ) : ?>
							<ol class="publications-list list-unstyled mb-0">
								<?php foreach ( $items as $publication_post ) : ?>
									<li class="publications-list__item">
										<?php
										get_template_part(
											'template-parts/publications/publication',
											'item',
											array(
												'publication_post' => $publication_post,
												'context'          => 'year',
											)
										);
										?>
									</li>
								<?php endforeach; ?>
							</ol>
						<?php else : ?>
							<div class="publications-empty">
								<p class="mb-0">
									<<?php echo esc_html( function_exists( 'inlife_t' ) ? inlife_t( 'Brak publikacji do wyświetlenia dla tego roku.' ) : __( 'Brak publikacji do wyświetlenia dla tego roku.', 'newinlife-child' ) ); ?>
								</p>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</section>

</main>

<?php
get_footer();
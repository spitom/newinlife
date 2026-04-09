<?php
/**
 * Template Name: Publications Index
 *
 * @package newinlife-child
 */

defined( 'ABSPATH' ) || exit;

get_header();

$container = function_exists( 'inlife_container_class' ) ? inlife_container_class() : 'container';
$years     = function_exists( 'inlife_get_publication_year_overview' ) ? inlife_get_publication_year_overview() : array();
?>

<main id="main-content" class="site-main site-main--landing site-main--publications-index">

	<section class="page-section page-section--publications-index-hero">
		<?php
		get_template_part(
			'template-parts/patterns/pattern-page-hero',
			null,
			array(
				'kicker'      => function_exists( 'inlife_t' ) ? inlife_t( 'Badania' ) : __( 'Badania', 'newinlife-child' ),
				'title'       => get_the_title(),
				'lead'        => function_exists( 'inlife_t' ) ? inlife_t( 'Przegląd dorobku publikacyjnego Instytutu w podziale na lata.' ) : __( 'Przegląd dorobku publikacyjnego Instytutu w podziale na lata.', 'newinlife-child' ),
				'breadcrumbs' => true,
				'modifier'    => 'flush',
			)
		);
		?>
	</section>

	<section class="page-section page-section--publications-years" aria-labelledby="publications-years-heading">
		<div class="<?php echo esc_attr( $container ); ?>">
			<div class="publications-years">
				<div class="row">
					<div class="col-xl-10">
						<h2 id="publications-years-heading" class="publications-years__heading">
							<?php echo esc_html( function_exists( 'inlife_t' ) ? inlife_t( 'Wybierz rok' ) : __( 'Wybierz rok', 'newinlife-child' ) ); ?>
						</h2>
					</div>
				</div>

				<?php if ( ! empty( $years ) ) : ?>
					<div class="publications-nav-wrap">
						<nav class="publications-nav" aria-label="<?php echo esc_attr( function_exists( 'inlife_t' ) ? inlife_t( 'Lata publikacji' ) : __( 'Lata publikacji', 'newinlife-child' ) ); ?>">
							<?php foreach ( $years as $year_item ) : ?>
								<?php
								$year  = $year_item['year'];
								$count = $year_item['count'];

								$url = home_url( '/badania/publikacje-' . $year . '/' );

								if ( function_exists( 'pll_current_language' ) && 'en' === pll_current_language() ) {
									$url = home_url( '/en/research/publications-' . $year . '/' );
								}
								?>

								<a class="publications-nav__btn" href="<?php echo esc_url( $url ); ?>">
									<?php echo esc_html( $year ); ?>

									<span class="publications-nav__count">
										<?php
										printf(
											esc_html(
												function_exists( 'inlife_t' )
													? inlife_t( '%d publikacji' )
													: __( '%d publikacji', 'newinlife-child' )
											),
											(int) $count
										);
										?>
									</span>
								</a>
							<?php endforeach; ?>
						</nav>
					</div>
				<?php else : ?>
					<div class="publications-empty">
						<p class="mb-0">
							<?php echo esc_html( function_exists( 'inlife_t' ) ? inlife_t( 'Brak publikacji do wyświetlenia.' ) : __( 'Brak publikacji do wyświetlenia.', 'newinlife-child' ) ); ?>
						</p>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>

</main>

<?php
get_footer();
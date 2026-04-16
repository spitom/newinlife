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

$hero_title = $current_year ? $current_year : get_the_title();

$hero_lead = '';
if ( $current_year ) {
	$hero_lead = sprintf(
		function_exists( 'inlife_t' )
			? inlife_t( 'Lista publikacji naukowych z roku %s.' )
			: __( 'Lista publikacji naukowych z roku %s.', 'newinlife-child' ),
		$current_year
	);
}

$back_url = home_url( '/badania/publikacje/' );

if ( function_exists( 'pll_home_url' ) && function_exists( 'pll_current_language' ) ) {
	$back_url = trailingslashit( pll_home_url() ) . ( 'en' === pll_current_language() ? 'research/publications/' : 'badania/publikacje/' );
}

ob_start();
?>
<a class="publications-year-back c-readmore" href="<?php echo esc_url( $back_url ); ?>">
	<span class="c-readmore__icon" aria-hidden="true">←</span>
	<?php
	echo esc_html(
		function_exists( 'inlife_t' )
			? inlife_t( 'Wróć do listy lat' )
			: __( 'Wróć do listy lat', 'newinlife-child' )
	);
	?>
</a>
<?php
$hero_actions = trim( (string) ob_get_clean() );
?>

<main id="main-content" class="site-main site-main--landing site-main--publications-year">

	<section class="page-section page-section--publications-year-hero">
		<?php
		get_template_part(
			'template-parts/patterns/pattern-page-hero',
			null,
			array(
				'kicker'       => function_exists( 'inlife_t' ) ? inlife_t( 'Publikacje' ) : __( 'Publikacje', 'newinlife-child' ),
				'title'        => $hero_title,
				'lead'         => $hero_lead,
				'breadcrumbs'  => true,
				'modifier'     => 'flush',
				'actions_html' => $hero_actions,
			)
		);
		?>
	</section>

	<section class="page-section page-section--publications-list" aria-labelledby="publications-list-heading">
		<div class="<?php echo esc_attr( $container ); ?>">
			<div class="publications-year-list-wrap">
				<h2 id="publications-list-heading" class="visually-hidden">
					<?php echo esc_html( $hero_title ); ?>
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
					<div class="publications-empty c-surface c-surface--soft c-surface--panel">
						<p class="mb-0">
							<?php
							echo esc_html(
								function_exists( 'inlife_t' )
									? inlife_t( 'Brak publikacji do wyświetlenia dla tego roku.' )
									: __( 'Brak publikacji do wyświetlenia dla tego roku.', 'newinlife-child' )
							);
							?>
						</p>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>

</main>

<?php
get_footer();
<?php
/**
 * Taxonomy Career Entry Type
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

get_header();

$container    = inlife_container_class();
$current_term = get_queried_object();

$term_title = single_term_title( '', false );
$term_lead  = ! empty( $current_term->description )
	? $current_term->description
	: inlife_t( 'Przeglądaj ogłoszenia i komunikaty przypisane do wybranej kategorii.' );

ob_start();
?>
<nav class="c-breadcrumbs" aria-label="<?php echo esc_attr( inlife_t( 'Okruszki' ) ); ?>">
	<ol class="c-breadcrumbs__list">
		<li class="c-breadcrumbs__item">
			<a class="c-breadcrumbs__link" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<?php echo esc_html( inlife_t( 'Strona główna' ) ); ?>
			</a>
		</li>
		<li class="c-breadcrumbs__item">
			<a class="c-breadcrumbs__link" href="<?php echo esc_url( home_url( '/kariera/' ) ); ?>">
				<?php echo esc_html( inlife_t( 'Kariera' ) ); ?>
			</a>
		</li>
		<li class="c-breadcrumbs__item">
			<a class="c-breadcrumbs__link" href="<?php echo esc_url( home_url( '/kariera/konkursy-i-oferty-pracy/' ) ); ?>">
				<?php echo esc_html( inlife_t( 'Konkursy i oferty pracy' ) ); ?>
			</a>
		</li>
		<li class="c-breadcrumbs__item c-breadcrumbs__item--current" aria-current="page">
			<span class="c-breadcrumbs__current"><?php echo esc_html( $term_title ); ?></span>
		</li>
	</ol>
</nav>
<?php
$custom_breadcrumbs = (string) ob_get_clean();
?>

<main id="main-content" class="site-main site-main--career-taxonomy">

	<section class="page-section page-section--career-taxonomy-hero" aria-labelledby="career-taxonomy-heading">
		<?php
		get_template_part(
			'template-parts/patterns/pattern-page-hero',
			null,
			[
				'kicker'      => inlife_t( 'Kariera' ),
				'title'       => $term_title,
				'lead'        => $term_lead,
				'breadcrumbs' => $custom_breadcrumbs,
				'modifier' => [ 'archive', 'flush' ],
				'title_id'    => 'career-taxonomy-heading',
			]
		);
		?>
	</section>

	<section class="page-section page-section--career-taxonomy-loop">
		<div class="<?php echo esc_attr( $container ); ?>">
			<?php get_template_part( 'template-parts/career/career-archive', 'loop' ); ?>
		</div>
	</section>

</main>

<?php
get_footer();
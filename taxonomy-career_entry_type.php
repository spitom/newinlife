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
$term_lead  = ! empty( $current_term->description ) ? $current_term->description : inlife_t( 'Przeglądaj ogłoszenia i komunikaty przypisane do wybranej kategorii.' );
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
				'breadcrumbs' => true,
				'modifier'    => 'archive',
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
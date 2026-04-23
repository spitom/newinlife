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
$term_lead  = ! empty( $current_term->description ) ? $current_term->description : '';
?>

<main id="main-content" class="site-main site-main--career-taxonomy">

	<section class="page-section page-section--career-taxonomy-intro" aria-labelledby="career-taxonomy-heading">
		<div class="<?php echo esc_attr( $container ); ?>">
			<?php
			get_template_part(
				'template-parts/components/section-header',
				null,
				[
					'kicker'   => inlife_t( 'Kariera' ),
					'title'    => $term_title,
					'lead'     => $term_lead,
					'title_id' => 'career-taxonomy-heading',
				]
			);
			?>
		</div>
	</section>

	<section class="page-section page-section--career-taxonomy-loop">
		<div class="<?php echo esc_attr( $container ); ?>">
			<?php get_template_part( 'template-parts/career/career-archive', 'loop' ); ?>
		</div>
	</section>

</main>

<?php
get_footer();
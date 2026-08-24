<?php
/**
 * Event type taxonomy template.
 *
 * @package newinlife
 */

defined( 'ABSPATH' ) || exit;

get_header();

$term = get_queried_object();

if ( ! $term instanceof WP_Term ) {
	get_footer();
	return;
}
?>

<main id="main-content" class="site-main site-main--event-type">

	<section class="page-section page-section--event-type-hero">
		<?php
		get_template_part(
			'template-parts/patterns/pattern-page-hero',
			null,
			[
				'kicker'      => inlife_t( 'Wydarzenia' ),
				'title'       => $term->name,
				'lead'        => '',
				'breadcrumbs' => true,
				'modifier'    => 'flush',
			]
		);
		?>
	</section>

	<?php
	get_template_part(
		'template-parts/events/events-taxonomy',
		'content',
		[
			'term' => $term,
		]
	);
	?>

</main>

<?php
get_footer();
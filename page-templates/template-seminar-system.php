<?php
/**
 * Template Name: System seminariów instytutowych
 * Template Post Type: page
 *
 * @package newinlife
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="main-content" class="site-main site-main--seminar-system">

	<section class="page-section page-section--seminar-system-hero">
		<?php
		get_template_part(
			'template-parts/patterns/pattern-page-hero',
			null,
			[
				'kicker'      => inlife_t( 'Wydarzenia' ),
				'title'       => get_the_title(),
				'lead'        => '',
				'breadcrumbs' => true,
				'modifier'    => 'flush',
			]
		);
		?>
	</section>

	<?php
	get_template_part(
		'template-parts/events/seminar-system-content'
	);
	?>

</main>

<?php
get_footer();
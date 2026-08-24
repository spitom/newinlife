<?php
/**
 * Archive template for Events
 *
 * @package newinlife
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="main-content" class="site-main site-main--events">

	<section class="page-section page-section--events-hero">
		<?php
		get_template_part(
			'template-parts/patterns/pattern-page-hero',
			null,
			[
				'kicker'      => inlife_t( 'Wydarzenia' ),
				'title'       => inlife_get_archive_title( 'events' ),
				'lead'        => inlife_t( 'Konferencje, seminaria naukowe i najważniejsze wydarzenia organizowane przez InLife.' ),
				'breadcrumbs' => true,
				'modifier'    => 'flush',
			]
		);
		?>
	</section>

	<?php get_template_part( 'template-parts/events/events-archive', 'content' ); ?>

</main>

<?php
get_footer();
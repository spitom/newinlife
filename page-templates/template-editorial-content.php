<?php
/**
 * Template Name: Strona – treść edytowalna
 *
 * Generic editorial page for legal/footer pages edited with Gutenberg/Kadence.
 *
 * @package newinlife-child
 */

defined( 'ABSPATH' ) || exit;

get_header();

$post_id = get_the_ID();

$hero_kicker = function_exists( 'get_field' ) ? get_field( 'editorial_page_hero_kicker', $post_id ) : '';
$hero_title  = function_exists( 'get_field' ) ? get_field( 'editorial_page_hero_title', $post_id ) : '';
$hero_lead   = function_exists( 'get_field' ) ? get_field( 'editorial_page_hero_lead', $post_id ) : '';

if ( ! $hero_title ) {
	$hero_title = get_the_title();
}

if ( ! $hero_lead && has_excerpt( $post_id ) ) {
	$hero_lead = get_the_excerpt( $post_id );
}
?>

<main id="main-content" class="site-main site-main--editorial-page">

	<section class="page-section page-section--editorial-page-hero">
		<?php
		get_template_part(
			'template-parts/patterns/pattern-page-hero',
			null,
			[
				'kicker'      => $hero_kicker,
				'title'       => $hero_title,
				'lead'        => $hero_lead,
				'breadcrumbs' => true,
				'title_id'    => 'editorial-page-heading',
			]
		);
		?>
	</section>

	<?php
	while ( have_posts() ) :
		the_post();

		get_template_part(
			'template-parts/generic/content',
			'editorial-page',
			[
				'post_id' => get_the_ID(),
			]
		);
	endwhile;
	?>

</main>

<?php
get_footer();
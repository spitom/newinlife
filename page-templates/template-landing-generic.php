<?php
/**
 * Template Name: Landing – uniwersalny
 *
 * @package newinlife-child
 */

defined( 'ABSPATH' ) || exit;

get_header();

$container = function_exists( 'inlife_container_class' ) ? inlife_container_class() : 'container';
$post_id   = get_the_ID();

$hero_kicker = function_exists( 'get_field' ) ? get_field( 'generic_hero_kicker', $post_id ) : '';
$hero_title  = function_exists( 'get_field' ) ? get_field( 'generic_hero_title', $post_id ) : '';
$hero_lead   = function_exists( 'get_field' ) ? get_field( 'generic_hero_lead', $post_id ) : '';

if ( ! $hero_title ) {
	$hero_title = get_the_title();
}
?>

<main id="main-content" class="site-main site-main--landing-generic">

	<section class="page-section page-section--landing-generic-hero">
		<?php
		get_template_part(
			'template-parts/patterns/pattern-page-hero',
			null,
			[
				'kicker'      => $hero_kicker,
				'title'       => $hero_title,
				'lead'        => $hero_lead,
				'breadcrumbs' => true,
			]
		);
		?>
	</section>

	<?php if (have_rows('generic_sections')) : ?>

		<?php while (have_rows('generic_sections')) : the_row(); ?>

			<?php
			$layout = get_row_layout();

			get_template_part(
				'template-parts/generic/section',
				$layout
			);
			?>

		<?php endwhile; ?>

	<?php endif; ?>

</main>

<?php
get_footer();
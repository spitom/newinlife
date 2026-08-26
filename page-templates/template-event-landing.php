<?php
/**
 * Template Name: Landing wydarzenia / konferencji
 * Template Post Type: page
 *
 * @package newinlife
 */

defined( 'ABSPATH' ) || exit;

get_header();

$post_id = get_the_ID();

$hero_lead = function_exists( 'get_field' )
	? trim( (string) get_field( 'event_landing_hero_lead', $post_id ) )
	: '';

if ( ! $hero_lead && has_excerpt( $post_id ) ) {
	$hero_lead = get_the_excerpt( $post_id );
}

$hero_image_id = 0;

if ( function_exists( 'get_field' ) ) {
	$acf_hero_image = get_field( 'event_landing_hero_image', $post_id );

	if ( is_numeric( $acf_hero_image ) ) {
		$hero_image_id = (int) $acf_hero_image;
	}
}

if ( ! $hero_image_id && has_post_thumbnail( $post_id ) ) {
	$hero_image_id = (int) get_post_thumbnail_id( $post_id );
}
?>

<main id="main-content" class="site-main site-main--event-landing">

	<section class="page-section page-section--event-landing-hero">
        <?php
        get_template_part(
            'template-parts/patterns/pattern-media-hero',
            null,
            [
                'kicker'      => inlife_t( 'Wydarzenia' ),
                'title'       => get_the_title( $post_id ),
                'lead'        => $hero_lead,
                'image_id'    => $hero_image_id,
                'breadcrumbs' => true,
                'variant'     => 'event-landing',
            ]
        );
        ?>
    </section>

    <?php
    get_template_part(
        'template-parts/events/event-landing-nav'
    );
    ?>

    <section class="page-section page-section--event-landing-content">
        <div class="event-landing__content c-editorial-content">
            <?php
            while ( have_posts() ) :
                the_post();

                the_content();
            endwhile;
            ?>
        </div>
    </section>

    <?php
    get_template_part(
        'template-parts/events/event-landing-editions'
    );
    ?>

</main>

<?php
get_footer();
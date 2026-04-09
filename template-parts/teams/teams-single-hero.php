<?php
defined( 'ABSPATH' ) || exit;

$team_id = get_the_ID();
$terms   = get_the_terms( $team_id, 'team_area' );

$acf_lead = function_exists( 'get_field' ) ? get_field( 'team_lead', $team_id ) : '';
$lead     = $acf_lead ? $acf_lead : get_the_excerpt();

if ( ! $lead ) {
	$lead = wp_trim_words(
		wp_strip_all_tags(
			shortcode_unautop(
				strip_shortcodes( get_the_content() )
			)
		),
		28
	);
}

$hero_image_id = 0;

if ( function_exists( 'get_field' ) ) {
	$team_hero_image = get_field( 'team_hero_image', $team_id );

	if ( is_array( $team_hero_image ) && ! empty( $team_hero_image['ID'] ) ) {
		$hero_image_id = (int) $team_hero_image['ID'];
	} elseif ( is_numeric( $team_hero_image ) ) {
		$hero_image_id = (int) $team_hero_image;
	}
}

if ( ! $hero_image_id && has_post_thumbnail( $team_id ) ) {
	$hero_image_id = (int) get_post_thumbnail_id( $team_id );
}

$before_lead = '';

if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
	ob_start();
	?>
	<div class="p-media-hero__tags">
		<?php foreach ( $terms as $term ) : ?>
			<span class="p-media-hero__tag">
				<?php echo esc_html( $term->name ); ?>
			</span>
		<?php endforeach; ?>
	</div>
	<?php
	$before_lead = (string) ob_get_clean();
}

get_template_part(
	'template-parts/patterns/pattern-media-hero',
	null,
	[
		'kicker'      => inlife_t( 'Badania' ),
		'title'       => get_the_title( $team_id ),
		'lead'        => $lead,
		'image_id'    => $hero_image_id,
		'breadcrumbs' => true,
		'before_lead' => $before_lead,
	]
);
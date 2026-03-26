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

/*
 * Obraz hero:
 * 1. ACF team_hero_image
 * 2. featured image
 */
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

$hero_has_media    = ! empty( $hero_image_id );
$content_col_class = $hero_has_media ? 'col-lg-6' : 'col-12';
?>

<div class="team-hero<?php echo $hero_has_media ? '' : ' team-hero--no-media'; ?>">
	<div class="row align-items-center g-4 g-xl-5">

		<div class="<?php echo esc_attr( $content_col_class ); ?>">
			<div class="team-hero__content">
				<p class="section-kicker">
					<?php echo esc_html( inlife_t( 'Badania' ) ); ?>
				</p>

				<h1 class="team-hero__title"><?php the_title(); ?></h1>

				<?php if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) : ?>
					<div class="team-hero__areas">
						<?php foreach ( $terms as $term ) : ?>
							<span class="team-hero__area">
								<?php echo esc_html( $term->name ); ?>
							</span>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<?php if ( $lead ) : ?>
					<p class="team-hero__lead"><?php echo esc_html( $lead ); ?></p>
				<?php endif; ?>
			</div>
		</div>

		<?php if ( $hero_has_media ) : ?>
			<div class="col-lg-6">
				<div class="team-hero__visual">
					<?php
					echo wp_get_attachment_image(
						$hero_image_id,
						'large',
						false,
						array(
							'class'   => 'team-hero__image',
							'loading' => 'eager',
						)
					);
					?>
				</div>
			</div>
		<?php endif; ?>

	</div>
</div>
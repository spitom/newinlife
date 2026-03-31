<?php
defined( 'ABSPATH' ) || exit;

$laboratory_id = get_the_ID();

$acf_lead = function_exists( 'get_field' ) ? get_field( 'laboratory_lead', $laboratory_id ) : '';
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
	$laboratory_hero_image = get_field( 'laboratory_hero_image', $laboratory_id );

	if ( is_array( $laboratory_hero_image ) && ! empty( $laboratory_hero_image['ID'] ) ) {
		$hero_image_id = (int) $laboratory_hero_image['ID'];
	} elseif ( is_numeric( $laboratory_hero_image ) ) {
		$hero_image_id = (int) $laboratory_hero_image;
	}
}

if ( ! $hero_image_id && has_post_thumbnail( $laboratory_id ) ) {
	$hero_image_id = (int) get_post_thumbnail_id( $laboratory_id );
}

$hero_has_media    = ! empty( $hero_image_id );
$content_col_class = $hero_has_media ? 'col-lg-6' : 'col-12';
?>

<div class="lab-hero<?php echo $hero_has_media ? '' : ' lab-hero--no-media'; ?>">
	<div class="row align-items-center g-4 g-xl-5">

		<div class="<?php echo esc_attr( $content_col_class ); ?>">
			<div class="lab-hero__content">
				<p class="section-kicker">
					<?php echo esc_html( inlife_t( 'Badania' ) ); ?>
				</p>

				<h1 class="lab-hero__title"><?php the_title(); ?></h1>

				<?php if ( $lead ) : ?>
					<p class="lab-hero__lead"><?php echo esc_html( $lead ); ?></p>
				<?php endif; ?>
			</div>
		</div>

		<?php if ( $hero_has_media ) : ?>
			<div class="col-lg-6">
				<div class="lab-hero__visual">
					<?php
					echo wp_get_attachment_image(
						$hero_image_id,
						'large',
						false,
						array(
							'class'   => 'lab-hero__image',
							'loading' => 'eager',
						)
					);
					?>
				</div>
			</div>
		<?php endif; ?>

	</div>
</div>
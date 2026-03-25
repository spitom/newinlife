<?php
defined( 'ABSPATH' ) || exit;

$acf_lead = function_exists( 'get_field' ) ? get_field( 'laboratory_lead' ) : '';
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

$hero_image_id = function_exists( 'get_field' ) ? get_field( 'laboratory_hero_image' ) : '';
?>

<div class="lab-hero">
	<div class="row align-items-center g-4 g-xl-5">

		<div class="col-lg-6">
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

		<div class="col-lg-6">
			<div class="lab-hero__visual" aria-hidden="true">

				<?php if ( $hero_image_id ) : ?>
					<?php
					echo wp_get_attachment_image(
						$hero_image_id,
						'large',
						false,
						array(
							'class' => 'lab-hero__image',
						)
					);
					?>
				<?php else : ?>
					<span class="lab-hero__visual-label">
						<?php echo esc_html( inlife_t( 'Laboratorium' ) ); ?>
					</span>
				<?php endif; ?>

			</div>
		</div>

	</div>
</div>
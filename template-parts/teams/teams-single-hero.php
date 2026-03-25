<?php
defined( 'ABSPATH' ) || exit;

$terms = get_the_terms( get_the_ID(), 'team_area' );
$area  = ( ! empty( $terms ) && ! is_wp_error( $terms ) ) ? $terms[0]->name : '';

$acf_lead = function_exists( 'get_field' ) ? get_field( 'team_lead' ) : '';
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

$hero_image_id = function_exists( 'get_field' ) ? get_field( 'team_hero_image' ) : '';
?>

<div class="team-hero">
	<div class="row align-items-center g-4 g-xl-5">

		<div class="col-lg-6">
			<div class="team-hero__content">
				<p class="section-kicker">
					<?php echo esc_html( inlife_t( 'Badania' ) ); ?>
				</p>

				<h1 class="team-hero__title"><?php the_title(); ?></h1>

				<?php if ( $area ) : ?>
					<p class="team-hero__area"><?php echo esc_html( $area ); ?></p>
				<?php endif; ?>

				<?php if ( $lead ) : ?>
					<p class="team-hero__lead"><?php echo esc_html( $lead ); ?></p>
				<?php endif; ?>
			</div>
		</div>

		<div class="col-lg-6">
			<div class="team-hero__visual" aria-hidden="true">

				<?php if ( $hero_image_id ) : ?>
					<?php
					echo wp_get_attachment_image(
						$hero_image_id,
						'large',
						false,
						array(
							'class' => 'team-hero__image',
						)
					);
					?>
				<?php else : ?>
					<span class="team-hero__visual-label">
						<?php echo esc_html( $area ? $area : inlife_t( 'Zespół badawczy' ) ); ?>
					</span>
				<?php endif; ?>

			</div>
		</div>

	</div>
</div>
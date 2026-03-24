<?php
defined( 'ABSPATH' ) || exit;

$terms = get_the_terms( get_the_ID(), 'team_area' );
$area  = ( ! empty( $terms ) && ! is_wp_error( $terms ) ) ? $terms[0]->name : '';
$raw_excerpt = has_excerpt() ? get_the_excerpt() : get_the_content();

$lead = wp_trim_words(
	wp_strip_all_tags(
		shortcode_unautop(
			strip_shortcodes( $raw_excerpt )
		)
	),
	28
);
?>

<div class="team-hero">
	<div class="row align-items-center g-4 g-xl-5">

		<div class="col-lg-6">
			<div class="team-hero__content">
				<p class="section-kicker">
					<?php esc_html_e( 'Badania', 'newinlife' ); ?>
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
				<span class="team-hero__visual-label">
					<?php echo esc_html( $area ? $area : __( 'Zespół badawczy', 'newinlife' ) ); ?>
				</span>
			</div>
		</div>

	</div>
</div>
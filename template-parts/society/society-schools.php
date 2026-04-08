<?php
defined( 'ABSPATH' ) || exit;

$post_id   = $args['post_id'] ?? get_the_ID();
$container = $args['container'] ?? 'container';

$kicker         = get_field( 'schools_kicker', $post_id );
$title          = get_field( 'schools_title', $post_id );
$text           = get_field( 'schools_text', $post_id );
$points         = get_field( 'schools_points', $post_id );
$form_shortcode = get_field( 'schools_form_shortcode', $post_id );
$primary_cta    = get_field( 'schools_primary_cta', $post_id );
$secondary_cta  = get_field( 'schools_secondary_cta', $post_id );

$title = $title ?: inlife_t( 'Dla szkół' );

if ( ! $title && ! $text && ! $form_shortcode ) {
	return;
}
?>

<section class="society-section society-section--schools">
	<div class="<?php echo esc_attr( $container ); ?>">
		<div class="society-schools">
			<div class="society-schools__content">
				<?php if ( $kicker ) : ?>
					<p class="society-section-kicker"><?php echo esc_html( $kicker ); ?></p>
				<?php endif; ?>

				<?php if ( $title ) : ?>
					<h2 class="society-section-title"><?php echo esc_html( $title ); ?></h2>
				<?php endif; ?>

				<?php if ( $text ) : ?>
					<div class="society-wysiwyg">
						<?php echo wp_kses_post( $text ); ?>
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $points ) && is_array( $points ) ) : ?>
					<ul class="society-schools__points">
						<?php foreach ( $points as $point ) : ?>
							<?php if ( empty( $point['text'] ) ) { continue; } ?>
							<li><?php echo esc_html( $point['text'] ); ?></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>

				<?php if ( ! empty( $primary_cta ) || ! empty( $secondary_cta ) ) : ?>
					<div class="society-schools__actions">
						<?php if ( ! empty( $primary_cta['url'] ) && ! empty( $primary_cta['title'] ) ) : ?>
							<a
								class="btn btn-primary"
								href="<?php echo esc_url( $primary_cta['url'] ); ?>"
								<?php echo ! empty( $primary_cta['target'] ) ? 'target="' . esc_attr( $primary_cta['target'] ) . '"' : ''; ?>
							>
								<?php echo esc_html( $primary_cta['title'] ); ?>
							</a>
						<?php endif; ?>

						<?php if ( ! empty( $secondary_cta['url'] ) && ! empty( $secondary_cta['title'] ) ) : ?>
							<a
								class="btn btn-outline-primary"
								href="<?php echo esc_url( $secondary_cta['url'] ); ?>"
								<?php echo ! empty( $secondary_cta['target'] ) ? 'target="' . esc_attr( $secondary_cta['target'] ) . '"' : ''; ?>
							>
								<?php echo esc_html( $secondary_cta['title'] ); ?>
							</a>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>

			<?php if ( $form_shortcode ) : ?>
				<div class="society-schools__form">
					<?php echo do_shortcode( wp_kses_post( $form_shortcode ) ); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
<?php
defined( 'ABSPATH' ) || exit;

$post_id   = $args['post_id'] ?? get_the_ID();
$container = $args['container'] ?? 'container';

$title         = get_field( 'cta_title', $post_id );
$text          = get_field( 'cta_text', $post_id );
$primary_cta   = get_field( 'cta_primary', $post_id );
$secondary_cta = get_field( 'cta_secondary', $post_id );

if ( empty( $title ) || empty( $primary_cta['url'] ) || empty( $primary_cta['title'] ) ) {
	return;
}
?>

<section class="society-section society-section--cta">
	<div class="<?php echo esc_attr( $container ); ?>">
		<div class="society-cta">
			<div class="society-cta__content">
				<h2 class="society-cta__title"><?php echo esc_html( $title ); ?></h2>

				<?php if ( $text ) : ?>
					<div class="society-cta__text">
						<p><?php echo esc_html( $text ); ?></p>
					</div>
				<?php endif; ?>
			</div>

			<div class="society-cta__actions">
				<a
					class="btn btn-primary"
					href="<?php echo esc_url( $primary_cta['url'] ); ?>"
					<?php echo ! empty( $primary_cta['target'] ) ? 'target="' . esc_attr( $primary_cta['target'] ) . '"' : ''; ?>
				>
					<?php echo esc_html( $primary_cta['title'] ); ?>
				</a>

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
		</div>
	</div>
</section>
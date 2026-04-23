<?php
/**
 * Society - CTA
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

$post_id   = $args['post_id'] ?? get_the_ID();
$container = $args['container'] ?? ( function_exists( 'inlife_container_class' ) ? inlife_container_class() : 'container' );

$title         = function_exists( 'get_field' ) ? get_field( 'cta_title', $post_id ) : '';
$text          = function_exists( 'get_field' ) ? get_field( 'cta_text', $post_id ) : '';
$primary_cta   = function_exists( 'get_field' ) ? get_field( 'cta_primary', $post_id ) : null;
$secondary_cta = function_exists( 'get_field' ) ? get_field( 'cta_secondary', $post_id ) : null;

$has_primary_cta   = ! empty( $primary_cta['url'] ) && ! empty( $primary_cta['title'] );
$has_secondary_cta = ! empty( $secondary_cta['url'] ) && ! empty( $secondary_cta['title'] );

if ( empty( $title ) || ! $has_primary_cta ) {
	return;
}
?>

<section class="society-section society-section--cta" aria-labelledby="society-cta-heading">
	<div class="<?php echo esc_attr( $container ); ?>">
		<div class="society-cta c-surface">
			<div class="society-cta__content">
				<h2 id="society-cta-heading" class="society-cta__title">
					<?php echo esc_html( $title ); ?>
				</h2>

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

				<?php if ( $has_secondary_cta ) : ?>
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
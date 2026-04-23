<?php
/**
 * Society - Schools
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

$post_id   = $args['post_id'] ?? get_the_ID();
$container = $args['container'] ?? ( function_exists( 'inlife_container_class' ) ? inlife_container_class() : 'container' );

$kicker         = function_exists( 'get_field' ) ? get_field( 'schools_kicker', $post_id ) : '';
$title          = function_exists( 'get_field' ) ? get_field( 'schools_title', $post_id ) : '';
$text           = function_exists( 'get_field' ) ? get_field( 'schools_text', $post_id ) : '';
$points         = function_exists( 'get_field' ) ? get_field( 'schools_points', $post_id ) : [];
$form_shortcode = function_exists( 'get_field' ) ? get_field( 'schools_form_shortcode', $post_id ) : '';
$primary_cta    = function_exists( 'get_field' ) ? get_field( 'schools_primary_cta', $post_id ) : null;
$secondary_cta  = function_exists( 'get_field' ) ? get_field( 'schools_secondary_cta', $post_id ) : null;

$title = $title ?: inlife_t( 'Dla szkół' );

$has_points        = ! empty( $points ) && is_array( $points );
$has_form          = ! empty( $form_shortcode );
$has_primary_cta   = ! empty( $primary_cta['url'] ) && ! empty( $primary_cta['title'] );
$has_secondary_cta = ! empty( $secondary_cta['url'] ) && ! empty( $secondary_cta['title'] );

if ( empty( $text ) && ! $has_points && ! $has_form && ! $has_primary_cta && ! $has_secondary_cta ) {
	return;
}
?>

<section class="society-section society-section--schools" aria-labelledby="society-schools-heading">
	<div class="<?php echo esc_attr( $container ); ?>">
		<div class="society-schools">
			<div class="society-schools__content">
				<?php
				get_template_part(
					'template-parts/components/section-header',
					null,
					[
						'kicker'   => $kicker,
						'title'    => $title,
						'lead'     => '',
						'title_id' => 'society-schools-heading',
					]
				);
				?>

				<?php if ( $text ) : ?>
					<div class="entry-content society-schools__text">
						<?php echo wp_kses_post( $text ); ?>
					</div>
				<?php endif; ?>

				<?php if ( $has_points ) : ?>
					<ul class="society-schools__points" role="list">
						<?php foreach ( $points as $point ) : ?>
							<?php
							$point_text = $point['text'] ?? '';

							if ( '' === trim( (string) $point_text ) ) {
								continue;
							}
							?>
							<li class="society-schools__point">
								<span class="society-schools__point-text"><?php echo esc_html( $point_text ); ?></span>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>

				<?php if ( $has_primary_cta || $has_secondary_cta ) : ?>
					<div class="society-schools__actions">
						<?php if ( $has_primary_cta ) : ?>
							<a
								class="btn btn-primary"
								href="<?php echo esc_url( $primary_cta['url'] ); ?>"
								<?php echo ! empty( $primary_cta['target'] ) ? 'target="' . esc_attr( $primary_cta['target'] ) . '"' : ''; ?>
							>
								<?php echo esc_html( $primary_cta['title'] ); ?>
							</a>
						<?php endif; ?>

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
				<?php endif; ?>
			</div>

			<?php if ( $has_form ) : ?>
				<div class="society-schools__form">
					<div class="society-schools__form-surface c-surface">
						<?php echo do_shortcode( wp_kses_post( $form_shortcode ) ); ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
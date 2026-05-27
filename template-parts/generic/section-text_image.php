<?php
defined( 'ABSPATH' ) || exit;

$container = function_exists( 'inlife_container_class' ) ? inlife_container_class() : 'container';

$kicker         = get_sub_field( 'section_kicker' );
$title          = get_sub_field( 'section_title' );
$text           = get_sub_field( 'section_text' );
$image          = get_sub_field( 'section_image' );
$image_position = get_sub_field( 'section_image_position' ) ?: 'right';

$image_id = 0;

if ( is_array( $image ) && ! empty( $image['ID'] ) ) {
	$image_id = (int) $image['ID'];
} elseif ( is_numeric( $image ) ) {
	$image_id = (int) $image;
}

$classes = [
	'generic-text-image',
	'generic-text-image--image-' . sanitize_html_class( $image_position ),
];
?>

<section class="page-section generic-section generic-section--text-image">
	<div class="<?php echo esc_attr( $container ); ?>">
		<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">

			<div class="generic-text-image__content">
				<?php if ( $kicker || $title ) : ?>
					<header class="section-heading generic-text-image__header">
						<?php if ( $kicker ) : ?>
							<p class="section-kicker">
								<?php echo esc_html( $kicker ); ?>
							</p>
						<?php endif; ?>

						<?php if ( $title ) : ?>
							<h2 class="section-title">
								<?php echo esc_html( $title ); ?>
							</h2>
						<?php endif; ?>
					</header>
				<?php endif; ?>

				<?php if ( $text ) : ?>
					<div class="generic-text-image__text c-editorial-content">
						<?php echo wp_kses_post( $text ); ?>
					</div>
				<?php endif; ?>
			</div>

			<?php if ( $image_id ) : ?>
				<figure class="generic-text-image__media">
					<?php
					echo wp_get_attachment_image(
						$image_id,
						'large',
						false,
						[
							'class'   => 'generic-text-image__image',
							'loading' => 'lazy',
						]
					);
					?>
				</figure>
			<?php endif; ?>

		</div>
	</div>
</section>
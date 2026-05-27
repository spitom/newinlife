<?php
defined( 'ABSPATH' ) || exit;

$block_id = ! empty( $block['anchor'] ) ? $block['anchor'] : 'inlife-gallery-' . $block['id'];

$images  = get_field( 'block_gallery_images' );
$columns = get_field( 'block_gallery_columns' ) ?: '3';

if ( empty( $images ) || ! is_array( $images ) ) {
	return;
}

$classes = [
	'inlife-block',
	'inlife-block-gallery',
	'inlife-block-gallery--cols-' . sanitize_html_class( $columns ),
];
?>

<section id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">

	<div class="inlife-block-gallery__grid">

		<?php foreach ( $images as $image ) : ?>

			<?php
			$image_id = is_array( $image ) ? $image['ID'] : $image;

			$caption = '';

			if ( is_array( $image ) && ! empty( $image['caption'] ) ) {
				$caption = $image['caption'];
			}
			?>

			<figure class="inlife-block-gallery__item">

				<?php
				echo wp_get_attachment_image(
					$image_id,
					'large',
					false,
					[
						'class'   => 'inlife-block-gallery__image',
						'loading' => 'lazy',
					]
				);
				?>

				<?php if ( $caption ) : ?>
					<figcaption class="inlife-block-gallery__caption">
						<?php echo esc_html( $caption ); ?>
					</figcaption>
				<?php endif; ?>

			</figure>

		<?php endforeach; ?>

	</div>

</section>
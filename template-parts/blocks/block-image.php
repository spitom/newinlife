<?php
defined( 'ABSPATH' ) || exit;

$block_id = ! empty( $block['anchor'] ) ? $block['anchor'] : 'inlife-image-' . $block['id'];

$image   = get_field( 'block_image_image' );
$caption = get_field( 'block_image_caption' );
$variant = get_field( 'block_image_variant' ) ?: 'normal';

if ( ! $image ) {
	return;
}

$image_id = is_array( $image ) ? $image['ID'] : $image;

$classes = [
	'inlife-block',
	'inlife-block-image',
	'inlife-block-image--' . sanitize_html_class( $variant ),
];
?>

<figure id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<?php
	echo wp_get_attachment_image(
		$image_id,
		'large',
		false,
		[
			'class'   => 'inlife-block-image__img',
			'loading' => 'lazy',
		]
	);
	?>

	<?php if ( $caption ) : ?>
		<figcaption class="inlife-block-image__caption">
			<?php echo esc_html( $caption ); ?>
		</figcaption>
	<?php endif; ?>
</figure>
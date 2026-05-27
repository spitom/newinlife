<?php
defined( 'ABSPATH' ) || exit;

$block_id = ! empty( $block['anchor'] ) ? $block['anchor'] : 'inlife-highlight-' . $block['id'];

$kicker  = get_field( 'block_highlight_kicker' );
$title   = get_field( 'block_highlight_title' );
$content = get_field( 'block_highlight_content' );
$variant = get_field( 'block_highlight_variant' ) ?: 'default';

if ( ! $kicker && ! $title && ! $content ) {
	return;
}

$classes = [
	'inlife-block',
	'inlife-block-highlight',
	'inlife-block-highlight--' . sanitize_html_class( $variant ),
	'c-surface',
];
?>

<aside id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<?php if ( $kicker ) : ?>
		<p class="section-kicker"><?php echo esc_html( $kicker ); ?></p>
	<?php endif; ?>

	<?php if ( $title ) : ?>
		<h2 class="inlife-block-highlight__title">
			<?php echo esc_html( $title ); ?>
		</h2>
	<?php endif; ?>

	<?php if ( $content ) : ?>
		<div class="inlife-block-highlight__content c-editorial-content">
			<?php echo wp_kses_post( $content ); ?>
		</div>
	<?php endif; ?>
</aside>
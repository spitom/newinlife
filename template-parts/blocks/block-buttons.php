<?php
defined( 'ABSPATH' ) || exit;

$block_id = ! empty( $block['anchor'] ) ? $block['anchor'] : 'inlife-buttons-' . $block['id'];

if ( ! have_rows( 'block_buttons_items' ) ) {
	return;
}
?>

<div id="<?php echo esc_attr( $block_id ); ?>" class="inlife-block inlife-block-buttons">
	<div class="inlife-block-buttons__inner">

		<?php
		while ( have_rows( 'block_buttons_items' ) ) :
			the_row();

			$link  = get_sub_field( 'link' );
			$style = get_sub_field( 'style' ) ?: 'primary';

			if ( ! is_array( $link ) || empty( $link['url'] ) ) {
				continue;
			}

			$class = 'btn btn-primary';

			if ( 'secondary' === $style ) {
				$class = 'btn btn-outline-primary';
			} elseif ( 'link' === $style ) {
				$class = 'c-readmore';
			}
			?>

			<a
				class="<?php echo esc_attr( $class ); ?>"
				href="<?php echo esc_url( $link['url'] ); ?>"
				<?php if ( ! empty( $link['target'] ) ) : ?>
					target="<?php echo esc_attr( $link['target'] ); ?>"
				<?php endif; ?>
			>
				<?php echo esc_html( $link['title'] ?: __( 'Zobacz więcej', 'understrap-child' ) ); ?>
			</a>

		<?php endwhile; ?>

	</div>
</div>
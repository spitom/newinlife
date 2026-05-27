<?php
defined( 'ABSPATH' ) || exit;

$block_id = ! empty( $block['anchor'] ) ? $block['anchor'] : 'inlife-accordion-' . $block['id'];

if ( ! have_rows( 'block_accordion_items' ) ) {
	return;
}
?>

<section id="<?php echo esc_attr( $block_id ); ?>" class="inlife-block inlife-block-accordion">

	<div class="accordion accordion-inlife" id="<?php echo esc_attr( $block_id ); ?>-accordion">

		<?php
		$index = 0;

		while ( have_rows( 'block_accordion_items' ) ) :
			the_row();

			$index++;

			$title   = get_sub_field( 'title' );
			$content = get_sub_field( 'content' );

			if ( ! $title || ! $content ) {
				continue;
			}

			$item_id = $block_id . '-item-' . $index;
			?>

			<div class="accordion-item accordion-inlife__item">

				<h2 class="accordion-header" id="<?php echo esc_attr( $item_id ); ?>-heading">

					<button
						class="accordion-button collapsed accordion-inlife__button"
						type="button"
						data-bs-toggle="collapse"
						data-bs-target="#<?php echo esc_attr( $item_id ); ?>"
						aria-expanded="false"
						aria-controls="<?php echo esc_attr( $item_id ); ?>"
					>
						<?php echo esc_html( $title ); ?>
					</button>

				</h2>

				<div
					id="<?php echo esc_attr( $item_id ); ?>"
					class="accordion-collapse collapse"
					aria-labelledby="<?php echo esc_attr( $item_id ); ?>-heading"
					data-bs-parent="#<?php echo esc_attr( $block_id ); ?>-accordion"
				>

					<div class="accordion-body accordion-inlife__content c-editorial-content">
						<?php echo wp_kses_post( $content ); ?>
					</div>

				</div>

			</div>

		<?php endwhile; ?>

	</div>

</section>
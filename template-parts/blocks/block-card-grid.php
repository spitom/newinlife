<?php
defined( 'ABSPATH' ) || exit;

$block_id = ! empty( $block['anchor'] ) ? $block['anchor'] : 'inlife-card-grid-' . $block['id'];

$title   = get_field( 'block_card_grid_title' );
$columns = get_field( 'block_card_grid_columns' ) ?: '3';

if ( ! have_rows( 'block_card_grid_items' ) ) {
	return;
}

$classes = [
	'inlife-block',
	'inlife-block-card-grid',
	'inlife-block-card-grid--cols-' . sanitize_html_class( $columns ),
];
?>

<section id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">

	<?php if ( $title ) : ?>
		<header class="section-heading">
			<h2 class="section-title">
				<?php echo esc_html( $title ); ?>
			</h2>
		</header>
	<?php endif; ?>

	<div class="c-card-grid">

		<?php
		while ( have_rows( 'block_card_grid_items' ) ) :
			the_row();

			$item_title   = get_sub_field( 'title' );
			$item_text    = get_sub_field( 'text' );
			$item_link    = get_sub_field( 'link' );
			$item_image   = get_sub_field( 'image' );
			?>

			<article class="c-surface inlife-block-card-grid__item">

				<?php if ( $item_image ) : ?>

					<div class="inlife-block-card-grid__media">

						<?php
						$image_id = is_array( $item_image ) ? $item_image['ID'] : $item_image;

						echo wp_get_attachment_image(
							$image_id,
							'medium_large',
							false,
							[
								'class'   => 'inlife-block-card-grid__image',
								'loading' => 'lazy',
							]
						);
						?>

					</div>

				<?php endif; ?>

				<div class="inlife-block-card-grid__content">

					<?php if ( $item_title ) : ?>
						<h3 class="inlife-block-card-grid__title">
							<?php echo esc_html( $item_title ); ?>
						</h3>
					<?php endif; ?>

					<?php if ( $item_text ) : ?>
						<div class="inlife-block-card-grid__text c-editorial-content">
							<?php echo wp_kses_post( $item_text ); ?>
						</div>
					<?php endif; ?>

					<?php if ( is_array( $item_link ) && ! empty( $item_link['url'] ) ) : ?>

						<div class="inlife-block-card-grid__actions">

							<a
								class="c-readmore"
								href="<?php echo esc_url( $item_link['url'] ); ?>"
								<?php if ( ! empty( $item_link['target'] ) ) : ?>
									target="<?php echo esc_attr( $item_link['target'] ); ?>"
								<?php endif; ?>
							>
								<?php echo esc_html( $item_link['title'] ?: __( 'Zobacz więcej', 'understrap-child' ) ); ?>
							</a>

						</div>

					<?php endif; ?>

				</div>

			</article>

		<?php endwhile; ?>

	</div>

</section>
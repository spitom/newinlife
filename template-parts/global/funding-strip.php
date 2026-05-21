<?php
defined( 'ABSPATH' ) || exit;

$front_page_id = (int) get_option( 'page_on_front' );

if ( ! $front_page_id ) {
	return;
}

$enabled = function_exists( 'get_field' ) ? get_field( 'funding_strip_enabled', $front_page_id ) : false;

if ( ! $enabled ) {
	return;
}

$items = function_exists( 'get_field' ) ? get_field( 'funding_strip_items', $front_page_id ) : [];

if ( empty( $items ) || ! is_array( $items ) ) {
	return;
}
?>

<section class="funding-strip" aria-label="<?php echo esc_attr( inlife_t( 'Informacja o finansowaniu' ) ); ?>">
	<div class="inlife-container">
		<div class="funding-strip__inner">

			<?php foreach ( $items as $item ) : ?>
				<?php
				$image = $item['logo'] ?? null;
				$text  = $item['text'] ?? '';
				$url   = $item['url'] ?? '';

				$image_id = 0;

				if ( is_array( $image ) && ! empty( $image['ID'] ) ) {
					$image_id = (int) $image['ID'];
				} elseif ( is_numeric( $image ) ) {
					$image_id = (int) $image;
				}

				if ( ! $image_id && ! $text ) {
					continue;
				}

				$tag = $url ? 'a' : 'div';
				?>

				<<?php echo esc_attr( $tag ); ?>
					class="funding-strip__item"
					<?php if ( $url ) : ?>
						href="<?php echo esc_url( $url ); ?>"
					<?php endif; ?>
				>
					<?php if ( $image_id ) : ?>
						<?php
						echo wp_get_attachment_image(
							$image_id,
							'medium',
							false,
							[
								'class' => 'funding-strip__image',
								'alt'   => is_array( $image ) && ! empty( $image['alt'] ) ? $image['alt'] : '',
							]
						);
						?>
					<?php endif; ?>

					<?php if ( $text ) : ?>
						<span class="funding-strip__text">
							<?php echo wp_kses_post( $text ); ?>
						</span>
					<?php endif; ?>
				</<?php echo esc_attr( $tag ); ?>>

			<?php endforeach; ?>

		</div>
	</div>
</section>
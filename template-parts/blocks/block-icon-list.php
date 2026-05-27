<?php
defined( 'ABSPATH' ) || exit;

$block_id = ! empty( $block['anchor'] ) ? $block['anchor'] : 'inlife-icon-list-' . $block['id'];

$title = get_field( 'block_icon_list_title' );

if ( ! have_rows( 'block_icon_list_items' ) ) {
	return;
}
?>

<section id="<?php echo esc_attr( $block_id ); ?>" class="inlife-block inlife-block-icon-list">

	<?php if ( $title ) : ?>
		<header class="section-heading">
			<h2 class="section-title">
				<?php echo esc_html( $title ); ?>
			</h2>
		</header>
	<?php endif; ?>

	<div class="inlife-block-icon-list__grid">

		<?php
		while ( have_rows( 'block_icon_list_items' ) ) :
			the_row();

			$icon    = get_sub_field( 'icon' );
			$item    = get_sub_field( 'title' );
			$content = get_sub_field( 'content' );
			?>

			<div class="inlife-block-icon-list__item c-surface">

				<?php if ( $icon ) : ?>
					<div class="inlife-block-icon-list__icon">
						<i class="bi bi-<?php echo esc_attr( $icon ); ?>" aria-hidden="true"></i>
					</div>
				<?php endif; ?>

				<?php if ( $item ) : ?>
					<h3 class="inlife-block-icon-list__title">
						<?php echo esc_html( $item ); ?>
					</h3>
				<?php endif; ?>

				<?php if ( $content ) : ?>
					<div class="inlife-block-icon-list__content c-editorial-content">
						<?php echo wp_kses_post( $content ); ?>
					</div>
				<?php endif; ?>

			</div>

		<?php endwhile; ?>

	</div>

</section>
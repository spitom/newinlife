<?php
defined( 'ABSPATH' ) || exit;

$block_id = ! empty( $block['anchor'] ) ? $block['anchor'] : 'inlife-table-' . $block['id'];

$caption = get_field( 'block_table_caption' );
$table   = get_field( 'block_table_html' );

if ( ! $table ) {
	return;
}
?>

<section id="<?php echo esc_attr( $block_id ); ?>" class="inlife-block inlife-block-table">

	<div class="table-responsive">

		<table class="table table-inlife">

			<?php if ( $caption ) : ?>
				<caption>
					<?php echo esc_html( $caption ); ?>
				</caption>
			<?php endif; ?>

			<?php echo wp_kses_post( $table ); ?>

		</table>

	</div>

</section>
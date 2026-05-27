<?php
defined( 'ABSPATH' ) || exit;

$block_id = ! empty( $block['anchor'] ) ? $block['anchor'] : 'inlife-downloads-' . $block['id'];

$title = get_field( 'block_downloads_title' );

if ( ! have_rows( 'block_downloads_items' ) ) {
	return;
}
?>

<section id="<?php echo esc_attr( $block_id ); ?>" class="inlife-block inlife-block-downloads">

	<?php if ( $title ) : ?>
		<header class="section-heading">
			<h2 class="section-title">
				<?php echo esc_html( $title ); ?>
			</h2>
		</header>
	<?php endif; ?>

	<div class="inlife-block-downloads__list">

		<?php
		while ( have_rows( 'block_downloads_items' ) ) :
			the_row();

			$file        = get_sub_field( 'file' );
			$file_title  = get_sub_field( 'title' );
			$description = get_sub_field( 'description' );

			if ( ! $file ) {
				continue;
			}

			$file_url  = $file['url'] ?? '';
			$file_name = $file_title ?: ( $file['title'] ?? '' );
			?>

			<article class="inlife-block-downloads__item c-surface">

				<div class="inlife-block-downloads__meta">

					<h3 class="inlife-block-downloads__title">
						<?php echo esc_html( $file_name ); ?>
					</h3>

					<?php if ( $description ) : ?>
						<div class="inlife-block-downloads__description c-editorial-content">
							<?php echo wp_kses_post( $description ); ?>
						</div>
					<?php endif; ?>

				</div>

				<div class="inlife-block-downloads__actions">

					<a
						class="btn btn-outline-primary"
						href="<?php echo esc_url( $file_url ); ?>"
						target="_blank"
						rel="noopener"
					>
						<?php esc_html_e( 'Pobierz', 'understrap-child' ); ?>
					</a>

				</div>

			</article>

		<?php endwhile; ?>

	</div>

</section>
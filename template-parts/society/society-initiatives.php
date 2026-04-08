<?php
defined( 'ABSPATH' ) || exit;

$post_id   = $args['post_id'] ?? get_the_ID();
$container = $args['container'] ?? 'container';

$kicker = get_field( 'initiatives_kicker', $post_id );
$title  = get_field( 'initiatives_title', $post_id );
$intro  = get_field( 'initiatives_intro', $post_id );
$pages  = get_field( 'initiatives_pages', $post_id );
$cta    = get_field( 'initiatives_cta', $post_id );

$title = $title ?: inlife_t( 'Projekty i inicjatywy' );

if ( empty( $pages ) || ! is_array( $pages ) ) {
	return;
}
?>

<section class="society-section society-section--initiatives">
	<div class="<?php echo esc_attr( $container ); ?>">
		<div class="society-section__header society-section__header--split">
			<div>
				<?php if ( $kicker ) : ?>
					<p class="society-section-kicker"><?php echo esc_html( $kicker ); ?></p>
				<?php endif; ?>

				<h2 class="society-section-title"><?php echo esc_html( $title ); ?></h2>

				<?php if ( $intro ) : ?>
					<div class="society-section-intro">
						<p><?php echo esc_html( $intro ); ?></p>
					</div>
				<?php endif; ?>
			</div>

			<?php if ( ! empty( $cta['url'] ) && ! empty( $cta['title'] ) ) : ?>
				<div class="society-section__actions">
					<a
						class="btn btn-outline-primary"
						href="<?php echo esc_url( $cta['url'] ); ?>"
						<?php echo ! empty( $cta['target'] ) ? 'target="' . esc_attr( $cta['target'] ) . '"' : ''; ?>
					>
						<?php echo esc_html( $cta['title'] ); ?>
					</a>
				</div>
			<?php endif; ?>
		</div>

		<div class="society-cards society-cards--initiatives">
			<?php foreach ( $pages as $page ) : ?>
				<?php
				$page_id = is_object( $page ) ? $page->ID : (int) $page;

				get_template_part(
					'template-parts/society/components/card',
					'initiative',
					[
						'post_id' => $page_id,
					]
				);
				?>
			<?php endforeach; ?>
		</div>
	</div>
</section>
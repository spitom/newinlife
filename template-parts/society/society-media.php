<?php
defined( 'ABSPATH' ) || exit;

$post_id   = $args['post_id'] ?? get_the_ID();
$container = $args['container'] ?? 'container';

$kicker = get_field( 'media_kicker', $post_id );
$title  = get_field( 'media_title', $post_id );
$intro  = get_field( 'media_intro', $post_id );
$posts  = get_field( 'media_posts', $post_id );
$cta    = get_field( 'media_cta', $post_id );

$title = $title ?: inlife_t( 'Podcasty i infografiki' );

if ( empty( $posts ) || ! is_array( $posts ) ) {
	return;
}
?>

<section class="society-section society-section--media">
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

		<div class="society-cards society-cards--media">
			<?php foreach ( $posts as $post ) : ?>
				<?php
				$post_id_item = is_object( $post ) ? $post->ID : (int) $post;

				get_template_part(
					'template-parts/society/components/card',
					'post',
					[
						'post_id' => $post_id_item,
					]
				);
				?>
			<?php endforeach; ?>
		</div>
	</div>
</section>
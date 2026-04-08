<?php
defined( 'ABSPATH' ) || exit;

$post_id   = $args['post_id'] ?? get_the_ID();
$container = $args['container'] ?? 'container';

$kicker         = get_field( 'hero_kicker', $post_id );
$title          = get_field( 'hero_title', $post_id );
$lead           = get_field( 'hero_lead', $post_id );
$primary_cta    = get_field( 'hero_primary_cta', $post_id );
$secondary_cta  = get_field( 'hero_secondary_cta', $post_id );
$media_type     = get_field( 'hero_media_type', $post_id );
$image          = get_field( 'hero_image', $post_id );
$video_embed    = get_field( 'hero_video_embed', $post_id );

$kicker = $kicker ?: inlife_t( 'Społeczeństwo' );
$title  = $title ?: get_the_title( $post_id );

if ( ! $title ) {
	return;
}

$has_media = false;

if ( 'image' === $media_type && ! empty( $image ) ) {
	$has_media = true;
} elseif ( 'video' === $media_type && ! empty( $video_embed ) ) {
	$has_media = true;
}
?>

<section class="society-hero">
	<div class="<?php echo esc_attr( $container ); ?>">
		<div class="society-hero__inner<?php echo $has_media ? ' society-hero__inner--has-media' : ''; ?>">
			<div class="society-hero__content">
				<?php if ( $kicker ) : ?>
					<p class="society-section-kicker"><?php echo esc_html( $kicker ); ?></p>
				<?php endif; ?>

				<h1 class="society-hero__title"><?php echo esc_html( $title ); ?></h1>

				<?php if ( $lead ) : ?>
					<div class="society-hero__lead">
						<p><?php echo esc_html( $lead ); ?></p>
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $primary_cta ) || ! empty( $secondary_cta ) ) : ?>
					<div class="society-hero__actions">
						<?php if ( ! empty( $primary_cta['url'] ) && ! empty( $primary_cta['title'] ) ) : ?>
							<a
								class="btn btn-primary"
								href="<?php echo esc_url( $primary_cta['url'] ); ?>"
								<?php echo ! empty( $primary_cta['target'] ) ? 'target="' . esc_attr( $primary_cta['target'] ) . '"' : ''; ?>
							>
								<?php echo esc_html( $primary_cta['title'] ); ?>
							</a>
						<?php endif; ?>

						<?php if ( ! empty( $secondary_cta['url'] ) && ! empty( $secondary_cta['title'] ) ) : ?>
							<a
								class="btn btn-outline-primary"
								href="<?php echo esc_url( $secondary_cta['url'] ); ?>"
								<?php echo ! empty( $secondary_cta['target'] ) ? 'target="' . esc_attr( $secondary_cta['target'] ) . '"' : ''; ?>
							>
								<?php echo esc_html( $secondary_cta['title'] ); ?>
							</a>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>

			<?php if ( $has_media ) : ?>
				<div class="society-hero__media">
					<?php if ( 'image' === $media_type && ! empty( $image ) ) : ?>
						<div class="society-hero__image">
							<?php
							echo wp_get_attachment_image(
								$image['ID'],
								'large',
								false,
								[
									'class' => 'img-fluid',
									'alt'   => $image['alt'] ?: '',
								]
							);
							?>
						</div>
					<?php elseif ( 'video' === $media_type && ! empty( $video_embed ) ) : ?>
						<div class="society-hero__video">
							<?php echo wp_kses_post( $video_embed ); ?>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
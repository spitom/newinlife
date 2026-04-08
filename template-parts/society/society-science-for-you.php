<?php
defined( 'ABSPATH' ) || exit;

$post_id   = $args['post_id'] ?? get_the_ID();
$container = $args['container'] ?? 'container';

$kicker      = get_field( 'science_kicker', $post_id );
$title       = get_field( 'science_title', $post_id );
$content     = get_field( 'science_content', $post_id );
$image       = get_field( 'science_image', $post_id );
$video_embed = get_field( 'science_video_embed', $post_id );
$points      = get_field( 'science_points', $post_id );

$title = $title ?: inlife_t( 'Nauka dla Ciebie' );

if ( ! $title && ! $content ) {
	return;
}

$has_media  = ! empty( $image ) || ! empty( $video_embed );
$has_points = ! empty( $points ) && is_array( $points );
?>

<section class="society-section society-section--science">
	<div class="<?php echo esc_attr( $container ); ?>">
		<div class="society-section__header">
			<?php if ( $kicker ) : ?>
				<p class="society-section-kicker"><?php echo esc_html( $kicker ); ?></p>
			<?php endif; ?>

			<?php if ( $title ) : ?>
				<h2 class="society-section-title"><?php echo esc_html( $title ); ?></h2>
			<?php endif; ?>
		</div>

		<div class="society-science<?php echo $has_media ? ' society-science--has-media' : ''; ?>">
			<div class="society-science__content">
				<?php if ( $content ) : ?>
					<div class="society-wysiwyg">
						<?php echo wp_kses_post( $content ); ?>
					</div>
				<?php endif; ?>

				<?php if ( $has_points ) : ?>
					<ul class="society-science__points">
						<?php foreach ( $points as $point ) : ?>
							<?php if ( empty( $point['text'] ) ) { continue; } ?>
							<li><?php echo esc_html( $point['text'] ); ?></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>

			<?php if ( $has_media ) : ?>
				<div class="society-science__media">
					<?php if ( ! empty( $video_embed ) ) : ?>
						<div class="society-science__video">
							<?php echo wp_kses_post( $video_embed ); ?>
						</div>
					<?php elseif ( ! empty( $image ) ) : ?>
						<div class="society-science__image">
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
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
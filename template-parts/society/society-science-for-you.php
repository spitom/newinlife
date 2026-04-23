<?php
/**
 * Society - Science for You
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

$post_id   = $args['post_id'] ?? get_the_ID();
$container = $args['container'] ?? ( function_exists( 'inlife_container_class' ) ? inlife_container_class() : 'container' );

$section_kicker = function_exists( 'get_field' ) ? get_field( 'science_kicker', $post_id ) : '';
$section_title  = function_exists( 'get_field' ) ? get_field( 'science_title', $post_id ) : '';
$section_text   = function_exists( 'get_field' ) ? get_field( 'science_content', $post_id ) : '';
$image          = function_exists( 'get_field' ) ? get_field( 'science_image', $post_id ) : null;
$video_embed    = function_exists( 'get_field' ) ? get_field( 'science_video_embed', $post_id ) : '';
$points         = function_exists( 'get_field' ) ? get_field( 'science_points', $post_id ) : [];

$section_title = $section_title ?: inlife_t( 'Nauka dla Ciebie' );

$has_media  = ! empty( $image ) || ! empty( $video_embed );
$has_points = ! empty( $points ) && is_array( $points );

if ( empty( $section_text ) && ! $has_media && ! $has_points ) {
	return;
}

$image_id  = 0;
$image_alt = '';

if ( is_array( $image ) ) {
	$image_id  = $image['ID'] ?? 0;
	$image_alt = $image['alt'] ?? '';
} elseif ( is_numeric( $image ) ) {
	$image_id = (int) $image;
}
?>

<section class="society-section society-section--science" aria-labelledby="society-science-heading">
	<div class="<?php echo esc_attr( $container ); ?>">
		<div class="society-science<?php echo $has_media ? ' society-science--has-media' : ' society-science--no-media'; ?>">
			<div class="society-science__content">
				<?php
				get_template_part(
					'template-parts/components/section-header',
					null,
					[
						'kicker'   => $section_kicker,
						'title'    => $section_title,
						'lead'     => '',
						'title_id' => 'society-science-heading',
					]
				);
				?>

				<?php if ( ! empty( $section_text ) ) : ?>
					<div class="entry-content society-science__wysiwyg">
						<?php echo wp_kses_post( $section_text ); ?>
					</div>
				<?php endif; ?>

				<?php if ( $has_points ) : ?>
					<ul class="society-science__points" role="list">
						<?php foreach ( $points as $point ) : ?>
							<?php
							$point_text = $point['text'] ?? '';

							if ( '' === trim( (string) $point_text ) ) {
								continue;
							}
							?>
							<li class="society-science__point">
								<span class="society-science__point-text"><?php echo esc_html( $point_text ); ?></span>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>

			<?php if ( $has_media ) : ?>
				<div class="society-science__media">
					<?php if ( ! empty( $video_embed ) ) : ?>
						<div class="society-science__video c-surface">
							<?php echo wp_kses_post( $video_embed ); ?>
						</div>
					<?php elseif ( $image_id ) : ?>
						<div class="society-science__image-wrap">
							<?php
							echo wp_get_attachment_image(
								$image_id,
								'large',
								false,
								[
									'class' => 'society-science__image img-fluid',
									'alt'   => $image_alt,
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
<?php
/**
 * Society - Science for You
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

$post_id   = $args['post_id'] ?? get_the_ID();
$container = $args['container'] ?? ( function_exists( 'inlife_container_class' ) ? inlife_container_class() : 'container' );

$section_kicker = inlife_get_acf_field( 'science_kicker', $post_id, '' );
$section_text = inlife_get_acf_field( 'science_content', $post_id, '' );
$image = inlife_get_acf_field( 'science_image', $post_id, null );
$video_embed = inlife_get_acf_field( 'science_video_embed', $post_id, '' );


$section_title = inlife_get_acf_field(
	'science_title',
	$post_id,
	inlife_t( 'Nauka dla Ciebie' )
);

$image_id = 0;

if ( is_array( $image ) && ! empty( $image['ID'] ) ) {
	$image_id = (int) $image['ID'];
} elseif ( is_numeric( $image ) ) {
	$image_id = (int) $image;
}

$video_html = '';

if ( ! empty( $video_embed ) ) {
	$video_html = trim( (string) $video_embed );

	if ( false === strpos( $video_html, '<iframe' ) ) {
		$oembed = wp_oembed_get( wp_strip_all_tags( $video_html ) );

		if ( $oembed ) {
			$video_html = $oembed;
		}
	}
}

$has_media = ! empty( $video_html ) || ! empty( $image_id );

if ( empty( $section_text ) && ! $has_media ) {
	return;
}

$allowed_video_html = [
	'iframe' => [
		'src'             => true,
		'title'           => true,
		'width'           => true,
		'height'          => true,
		'frameborder'     => true,
		'allow'           => true,
		'allowfullscreen' => true,
		'loading'         => true,
		'referrerpolicy'  => true,
	],
];
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
					<div class="entry-content society-science__text">
						<?php echo wp_kses_post( $section_text ); ?>
					</div>
				<?php endif; ?>
			</div>

			<?php if ( $has_media ) : ?>
				<div class="society-science__media">
					<?php if ( ! empty( $video_html ) ) : ?>
						<div class="society-science__video">
							<?php echo wp_kses( $video_html, $allowed_video_html ); ?>
						</div>
					<?php elseif ( $image_id ) : ?>
						<div class="society-science__image-wrapper">
							<?php
							echo wp_get_attachment_image(
								$image_id,
								'large',
								false,
								[
									'class' => 'society-science__image',
									'alt'   => '',
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
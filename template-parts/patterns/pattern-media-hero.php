<?php
defined( 'ABSPATH' ) || exit;

/**
 * Media hero (text + image/custom media)
 *
 * Args:
 * - kicker
 * - title (required)
 * - lead
 * - image_id (int)
 * - breadcrumbs (bool|callable|string|array)
 * - before_lead (string HTML)
 * - actions_html (string HTML)
 * - custom_media_html (string HTML)
 */

$args = wp_parse_args(
	$args ?? [],
	[
		'kicker'            => '',
		'title'             => '',
		'lead'              => '',
		'image_id'          => 0,
		'breadcrumbs'       => true,
		'before_lead'       => '',
		'actions_html'      => '',
		'custom_media_html' => '',
	]
);

$title = trim( (string) $args['title'] );

if ( '' === $title ) {
	return;
}

$kicker            = trim( (string) $args['kicker'] );
$lead              = (string) $args['lead'];
$image_id          = (int) $args['image_id'];
$breadcrumbs       = $args['breadcrumbs'];
$before_lead       = (string) $args['before_lead'];
$actions_html      = (string) $args['actions_html'];
$custom_media_html = (string) $args['custom_media_html'];

$has_media = ( $image_id > 0 ) || ( '' !== trim( $custom_media_html ) );
?>

<section class="p-media-hero<?php echo $has_media ? '' : ' p-media-hero--no-media'; ?>">
	<div class="p-media-hero__inner">
		<div class="p-media-hero__grid">
			<div class="p-media-hero__content">

				<?php if ( false !== $breadcrumbs ) : ?>
					<div class="p-media-hero__breadcrumbs">
						<?php
						if ( is_array( $breadcrumbs ) || true === $breadcrumbs ) {
							get_template_part( 'template-parts/components/breadcrumbs' );
						} else {
							if ( is_callable( $breadcrumbs ) ) {
								call_user_func( $breadcrumbs );
							} elseif ( is_string( $breadcrumbs ) && '' !== trim( $breadcrumbs ) ) {
								echo wp_kses_post( $breadcrumbs );
							}
						}
						?>
					</div>
				<?php endif; ?>

				<?php if ( '' !== $kicker ) : ?>
					<div class="p-media-hero__kicker">
						<?php echo esc_html( $kicker ); ?>
					</div>
				<?php endif; ?>

				<h1 class="p-media-hero__title">
					<?php echo esc_html( $title ); ?>
				</h1>

				<?php if ( '' !== trim( $before_lead ) ) : ?>
					<div class="p-media-hero__before-lead">
						<?php echo wp_kses_post( $before_lead ); ?>
					</div>
				<?php endif; ?>

				<?php if ( trim( wp_strip_all_tags( $lead ) ) ) : ?>
					<div class="p-media-hero__lead">
						<?php echo wp_kses_post( wpautop( $lead ) ); ?>
					</div>
				<?php endif; ?>

				<?php if ( '' !== trim( $actions_html ) ) : ?>
					<div class="p-media-hero__actions">
						<?php echo wp_kses_post( $actions_html ); ?>
					</div>
				<?php endif; ?>

			</div>

			<?php if ( $has_media ) : ?>
				<div class="p-media-hero__media">
					<?php if ( '' !== trim( $custom_media_html ) ) : ?>
						<?php echo wp_kses_post( $custom_media_html ); ?>
					<?php else : ?>
						<?php
						echo wp_get_attachment_image(
							$image_id,
							'large',
							false,
							[
								'class'   => 'p-media-hero__image',
								'loading' => 'eager',
							]
						);
						?>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
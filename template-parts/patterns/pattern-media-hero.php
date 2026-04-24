<?php
/**
 * Shared media hero pattern.
 *
 * Args:
 * - kicker (string)
 * - title (string) [required]
 * - lead (string)
 * - image_id (int)
 * - breadcrumbs (bool|callable|string|array)
 * - breadcrumbs_full_width (bool)
 * - before_lead (string HTML)
 * - actions_html (string HTML)
 * - custom_media_html (string HTML)
 * - media_shape (string|array) e.g. 'cut-tl', 'hex'
 * - variant (string|array) e.g. 'career' or ['career', 'compact']
 * - section_id (string)
 * - data_attrs (array)
 * - title_id (string)
 * - kicker_id (string)
 * - lead_id (string)
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? [],
	[
		'kicker'                 => '',
		'title'                  => '',
		'lead'                   => '',
		'image_id'               => 0,
		'breadcrumbs'            => true,
		'breadcrumbs_full_width' => false,
		'before_lead'            => '',
		'actions_html'           => '',
		'custom_media_html'      => '',
		'media_shape'            => '',
		'variant'                => '',
		'section_id'             => '',
		'data_attrs'             => [],
		'title_id'               => '',
		'kicker_id'              => '',
		'lead_id'                => '',
	]
);

$title = trim( (string) $args['title'] );

if ( '' === $title ) {
	return;
}

$kicker                 = trim( (string) $args['kicker'] );
$lead                   = (string) $args['lead'];
$image_id               = (int) $args['image_id'];
$breadcrumbs            = $args['breadcrumbs'];
$breadcrumbs_full_width = ! empty( $args['breadcrumbs_full_width'] );
$before_lead            = (string) $args['before_lead'];
$actions_html           = (string) $args['actions_html'];
$custom_media_html      = (string) $args['custom_media_html'];

$has_media = ( $image_id > 0 ) || ( '' !== trim( $custom_media_html ) );

/**
 * Section classes.
 */
$classes = [ 'p-media-hero' ];

if ( ! $has_media ) {
	$classes[] = 'p-media-hero--no-media';
}

$variant_input = $args['variant'];
$variants      = [];

if ( is_array( $variant_input ) ) {
	$variants = $variant_input;
} elseif ( is_string( $variant_input ) && '' !== trim( $variant_input ) ) {
	$variants = preg_split( '/\s+/', trim( $variant_input ) );
}

foreach ( $variants as $variant ) {
	$variant = trim( (string) $variant );

	if ( '' !== $variant ) {
		$classes[] = 'p-media-hero--' . sanitize_html_class( $variant );
	}
}

/**
 * Media classes.
 */
$media_classes = [ 'p-media-hero__media' ];

$shape_input = $args['media_shape'];
$shapes      = [];

if ( is_array( $shape_input ) ) {
	$shapes = $shape_input;
} elseif ( is_string( $shape_input ) && '' !== trim( $shape_input ) ) {
	$shapes = preg_split( '/\s+/', trim( $shape_input ) );
}

foreach ( $shapes as $shape ) {
	$shape = trim( (string) $shape );

	if ( '' !== $shape ) {
		$media_classes[] = 'p-media-hero__media--' . sanitize_html_class( $shape );
	}
}
?>

<section
	class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>"
	<?php if ( $args['section_id'] ) : ?>
		id="<?php echo esc_attr( $args['section_id'] ); ?>"
	<?php endif; ?>
	<?php if ( ! empty( $args['data_attrs'] ) && is_array( $args['data_attrs'] ) ) : ?>
		<?php foreach ( $args['data_attrs'] as $attr => $value ) : ?>
			data-<?php echo esc_attr( $attr ); ?>="<?php echo esc_attr( $value ); ?>"
		<?php endforeach; ?>
	<?php endif; ?>
>
	<div class="p-media-hero__inner">

		<?php if ( false !== $breadcrumbs && $breadcrumbs_full_width ) : ?>
			<div class="p-media-hero__breadcrumbs p-media-hero__breadcrumbs--full">
				<?php
				if ( is_array( $breadcrumbs ) || true === $breadcrumbs ) {
					get_template_part( 'template-parts/components/breadcrumbs' );
				} elseif ( is_callable( $breadcrumbs ) ) {
					call_user_func( $breadcrumbs );
				} elseif ( is_string( $breadcrumbs ) && '' !== trim( $breadcrumbs ) ) {
					echo wp_kses_post( $breadcrumbs );
				}
				?>
			</div>
		<?php endif; ?>

		<div class="p-media-hero__grid">
			<div class="p-media-hero__content">

				<?php if ( false !== $breadcrumbs && ! $breadcrumbs_full_width ) : ?>
					<div class="p-media-hero__breadcrumbs">
						<?php
						if ( is_array( $breadcrumbs ) || true === $breadcrumbs ) {
							get_template_part( 'template-parts/components/breadcrumbs' );
						} elseif ( is_callable( $breadcrumbs ) ) {
							call_user_func( $breadcrumbs );
						} elseif ( is_string( $breadcrumbs ) && '' !== trim( $breadcrumbs ) ) {
							echo wp_kses_post( $breadcrumbs );
						}
						?>
					</div>
				<?php endif; ?>

				<?php if ( '' !== $kicker ) : ?>
					<div
						class="p-media-hero__kicker"
						<?php if ( $args['kicker_id'] ) : ?>
							id="<?php echo esc_attr( $args['kicker_id'] ); ?>"
						<?php endif; ?>
					>
						<?php echo esc_html( $kicker ); ?>
					</div>
				<?php endif; ?>

				<h1
					class="p-media-hero__title"
					<?php if ( $args['title_id'] ) : ?>
						id="<?php echo esc_attr( $args['title_id'] ); ?>"
					<?php endif; ?>
				>
					<?php echo esc_html( $title ); ?>
				</h1>

				<?php if ( '' !== trim( $before_lead ) ) : ?>
					<div class="p-media-hero__before-lead">
						<?php echo wp_kses_post( $before_lead ); ?>
					</div>
				<?php endif; ?>

				<?php if ( trim( wp_strip_all_tags( $lead ) ) ) : ?>
					<div
						class="p-media-hero__lead"
						<?php if ( $args['lead_id'] ) : ?>
							id="<?php echo esc_attr( $args['lead_id'] ); ?>"
						<?php endif; ?>
					>
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
				<div class="<?php echo esc_attr( implode( ' ', $media_classes ) ); ?>">
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
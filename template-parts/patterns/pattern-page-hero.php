<?php
defined( 'ABSPATH' ) || exit;

/**
 * Shared page hero pattern.
 */

$args = wp_parse_args(
	$args ?? [],
	[
		'kicker'       => '',
		'title'        => '',
		'lead'         => '',
		'breadcrumbs'  => true,
		'modifier'     => '',
		'actions_html' => '',

		// 🔥 NOWE (pod JS teams)
		'section_id' => '',
		'data_attrs' => [],
		'title_id'   => '',
		'kicker_id'  => '',
		'lead_id'    => '',
	]
);

$title = trim( (string) $args['title'] );

if ( '' === $title ) {
	return;
}

$kicker       = trim( (string) $args['kicker'] );
$lead         = (string) $args['lead'];
$breadcrumbs  = $args['breadcrumbs'];
$modifier     = trim( (string) $args['modifier'] );
$actions_html = (string) $args['actions_html'];

$classes = [ 'p-page-hero' ];

if ( '' !== $modifier ) {
	$classes[] = 'p-page-hero--' . sanitize_html_class( $modifier );
}
?>

<section
	class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>"
	<?php if ( $args['section_id'] ) : ?>
		id="<?php echo esc_attr( $args['section_id'] ); ?>"
	<?php endif; ?>
	<?php if ( ! empty( $args['data_attrs'] ) ) : ?>
		<?php foreach ( $args['data_attrs'] as $attr => $value ) : ?>
			data-<?php echo esc_attr( $attr ); ?>="<?php echo esc_attr( $value ); ?>"
		<?php endforeach; ?>
	<?php endif; ?>
>
	<div class="p-page-hero__inner">

		<?php if ( false !== $breadcrumbs ) : ?>
			<div class="p-page-hero__breadcrumbs">
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

		<div class="p-page-hero__content">

			<?php if ( '' !== $kicker ) : ?>
				<div class="p-page-hero__kicker"
					<?php if ( $args['kicker_id'] ) : ?>
						id="<?php echo esc_attr( $args['kicker_id'] ); ?>"
					<?php endif; ?>
				>
					<?php echo esc_html( $kicker ); ?>
				</div>
			<?php endif; ?>

			<h1 class="p-page-hero__title"
				<?php if ( $args['title_id'] ) : ?>
					id="<?php echo esc_attr( $args['title_id'] ); ?>"
				<?php endif; ?>
			>
				<?php echo esc_html( $title ); ?>
			</h1>

			<?php if ( trim( wp_strip_all_tags( $lead ) ) ) : ?>
				<div class="p-page-hero__lead"
					<?php if ( $args['lead_id'] ) : ?>
						id="<?php echo esc_attr( $args['lead_id'] ); ?>"
					<?php endif; ?>
				>
					<?php echo wp_kses_post( wpautop( $lead ) ); ?>
				</div>
			<?php endif; ?>

			<?php if ( '' !== trim( $actions_html ) ) : ?>
				<div class="p-page-hero__actions">
					<?php echo wp_kses_post( $actions_html ); ?>
				</div>
			<?php endif; ?>

		</div>
	</div>
</section>
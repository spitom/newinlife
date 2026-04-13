<?php
defined( 'ABSPATH' ) || exit;

/**
 * Section header component
 *
 * Args:
 * - kicker (string)
 * - title (string) [required]
 * - lead (string)
 * - action_html (string)
 * - class (string)
 * - title_id (string) → ważne dla aria-labelledby
 */

$args = wp_parse_args(
	$args ?? [],
	[
		'kicker'      => '',
		'title'       => '',
		'lead'        => '',
		'action_html' => '',
		'class'       => '',
		'title_id'    => '',
	]
);

$title = trim( (string) $args['title'] );

if ( '' === $title ) {
	return;
}

$kicker      = trim( (string) $args['kicker'] );
$lead        = (string) $args['lead'];
$action_html = (string) $args['action_html'];
$title_id    = trim( (string) $args['title_id'] );

$classes = [ 'c-section-header' ];

if ( '' !== $action_html ) {
	$classes[] = 'c-section-header--with-action';
}

if ( '' !== trim( (string) $args['class'] ) ) {
	$classes[] = trim( (string) $args['class'] );
}
?>

<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<div class="c-section-header__inner">

		<div class="c-section-header__content">

			<?php if ( '' !== $kicker ) : ?>
				<p class="c-section-header__kicker">
					<?php echo esc_html( $kicker ); ?>
				</p>
			<?php endif; ?>

			<h2
				class="c-section-header__title"
				<?php if ( '' !== $title_id ) : ?>
					id="<?php echo esc_attr( $title_id ); ?>"
				<?php endif; ?>
			>
				<?php echo esc_html( $title ); ?>
			</h2>

			<?php if ( trim( wp_strip_all_tags( $lead ) ) ) : ?>
				<div class="c-section-header__lead">
					<?php echo wp_kses_post( wpautop( $lead ) ); ?>
				</div>
			<?php endif; ?>

		</div>

		<?php if ( '' !== trim( $action_html ) ) : ?>
			<div class="c-section-header__action">
				<?php echo wp_kses_post( $action_html ); ?>
			</div>
		<?php endif; ?>

	</div>
</div>
<?php
defined( 'ABSPATH' ) || exit;

/**
 * Shared page hero pattern.
 *
 * Expected args:
 * - kicker (string)
 * - title (string) [required]
 * - lead (string)
 * - breadcrumbs (string|callable|bool)
 * - modifier (string)
 * - actions_html (string HTML)
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

<section class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<div class="p-page-hero__inner">
		<div class="p-page-hero__content">

			<?php if ( false !== $breadcrumbs ) : ?>
				<div class="p-page-hero__breadcrumbs">
					<?php
					if ( is_callable( $breadcrumbs ) ) {
						call_user_func( $breadcrumbs );
					} elseif ( is_string( $breadcrumbs ) && '' !== trim( $breadcrumbs ) ) {
						echo wp_kses_post( $breadcrumbs );
					} elseif ( function_exists( 'rank_math_the_breadcrumbs' ) ) {
						rank_math_the_breadcrumbs();
					} elseif ( function_exists( 'yoast_breadcrumb' ) ) {
						yoast_breadcrumb( '<div>', '</div>' );
					}
					?>
				</div>
			<?php endif; ?>

			<?php if ( '' !== $kicker ) : ?>
				<div class="p-page-hero__kicker">
					<?php echo esc_html( $kicker ); ?>
				</div>
			<?php endif; ?>

			<h1 class="p-page-hero__title">
				<?php echo esc_html( $title ); ?>
			</h1>

			<?php if ( trim( wp_strip_all_tags( $lead ) ) ) : ?>
				<div class="p-page-hero__lead">
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
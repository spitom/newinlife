<?php
/**
 * Local navigation for event / conference landing pages.
 *
 * @package newinlife
 */

defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

$items = function_exists( 'get_field' )
	? get_field( 'event_landing_navigation', $post_id )
	: [];

if ( ! is_array( $items ) || empty( $items ) ) {
	return;
}

$navigation_items = [];

foreach ( $items as $item ) {
	$label  = isset( $item['event_landing_nav_label'] )
		? trim( (string) $item['event_landing_nav_label'] )
		: '';

	$anchor = isset( $item['event_landing_nav_anchor'] )
		? sanitize_title( (string) $item['event_landing_nav_anchor'] )
		: '';

	if ( '' === $label || '' === $anchor ) {
		continue;
	}

	$navigation_items[] = [
		'label'  => $label,
		'anchor' => $anchor,
	];
}

if ( empty( $navigation_items ) ) {
	return;
}
?>

<nav
	class="event-landing-nav"
	aria-label="<?php echo esc_attr( inlife_t( 'Sekcje wydarzenia' ) ); ?>"
>
	<div class="event-landing-nav__inner <?php echo esc_attr( inlife_container_class( 'content' ) ); ?>">
		<div class="event-landing-nav__scroll">
			<ul class="event-landing-nav__list">
				<?php foreach ( $navigation_items as $item ) : ?>
					<li class="event-landing-nav__item">
						<a
							class="event-landing-nav__link"
							href="#<?php echo esc_attr( $item['anchor'] ); ?>"
						>
							<?php echo esc_html( $item['label'] ); ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</nav>
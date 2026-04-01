<?php
/**
 * Publications year nav.
 *
 * @package newinlife-child
 */

defined( 'ABSPATH' ) || exit;

$grouped_publications = $args['grouped_publications'] ?? array();

if ( empty( $grouped_publications ) || ! is_array( $grouped_publications ) ) {
	return;
}
?>

<nav class="publications-year-nav" aria-label="<?php echo esc_attr( function_exists( 'inlife_t' ) ? inlife_t( 'Nawigacja po latach publikacji' ) : __( 'Nawigacja po latach publikacji', 'newinlife-child' ) ); ?>">
	<ul class="publications-year-nav__list list-unstyled mb-0">
		<?php foreach ( $grouped_publications as $year => $items ) : ?>
			<li class="publications-year-nav__item">
				<a class="publications-year-nav__link" href="#publications-year-<?php echo esc_attr( sanitize_title( $year ) ); ?>">
					<?php echo esc_html( $year ); ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</nav>
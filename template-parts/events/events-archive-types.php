<?php
/**
 * Events archive type navigation.
 *
 * @package newinlife
 */

defined( 'ABSPATH' ) || exit;

$current_language = function_exists( 'pll_current_language' )
	? pll_current_language( 'slug' )
	: 'pl';

$event_types = 'en' === $current_language
	? [
		'conferences',
		'seminars',
		'other-events',
	]
	: [
		'konferencje',
		'seminaria',
		'inne',
	];
?>

<nav
	class="events-type-nav"
	aria-label="<?php echo esc_attr( inlife_t( 'Typy wydarzeń' ) ); ?>"
>
	<?php foreach ( $event_types as $term_slug ) : ?>
		<?php
		$term = get_term_by( 'slug', $term_slug, 'event_type' );

		if ( ! $term instanceof WP_Term ) {
			continue;
		}

		$term_link = get_term_link( $term );

		if ( is_wp_error( $term_link ) ) {
			continue;
		}
		?>

		<a
			class="events-type-nav__link"
			href="<?php echo esc_url( $term_link ); ?>"
		>
			<?php echo esc_html( $term->name ); ?>
		</a>
	<?php endforeach; ?>
</nav>
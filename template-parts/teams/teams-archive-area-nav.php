<?php
/**
 * Teams archive area navigation.
 *
 * @package newinlife
 */

defined( 'ABSPATH' ) || exit;

$area_order = array( 'zywnosc', 'zwierzeta', 'zdrowie' );
?>

<section class="teams-area-nav section-sm">
	<div class="container">

		<div class="teams-area-nav__inner">
			<a href="#all" class="teams-area-nav__btn is-active">
				<?php echo esc_html( inlife_t( 'Wszystkie' ) ); ?>
			</a>

			<?php foreach ( $area_order as $slug ) : ?>
				<?php
				$term = get_term_by( 'slug', $slug, 'team_area' );

				if ( ! $term || is_wp_error( $term ) ) {
					continue;
				}
				?>
				<a href="#<?php echo esc_attr( $slug ); ?>" class="teams-area-nav__btn">
					<?php echo esc_html( $term->name ); ?>
				</a>
			<?php endforeach; ?>
		</div>

	</div>
</section>
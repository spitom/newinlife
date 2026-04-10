<?php
/**
 * Teams archive area navigation.
 *
 * @package newinlife
 */

defined( 'ABSPATH' ) || exit;

$area_order = array( 'zywnosc', 'zwierzeta', 'zdrowie' );
?>

<section class="teams-area-nav">
	<div class="container">

		<div
			class="teams-area-nav__inner"
			data-team-filters
			role="group"
			aria-label="<?php echo esc_attr( inlife_t( 'Filtruj zespoły według obszaru badawczego' ) ); ?>"
		>
			<button
				type="button"
				class="teams-area-nav__btn is-active"
				data-team-filter="all"
				aria-pressed="true"
			>
				<?php echo esc_html( inlife_t( 'Wszystkie' ) ); ?>
			</button>

			<?php foreach ( $area_order as $slug ) : ?>
				<?php
				$term = get_term_by( 'slug', $slug, 'team_area' );

				if ( ! $term || is_wp_error( $term ) ) {
					continue;
				}
				?>
				<button
					type="button"
					class="teams-area-nav__btn"
					data-team-filter="<?php echo esc_attr( $term->slug ); ?>"
					aria-pressed="false"
				>
					<?php echo esc_html( $term->name ); ?>
				</button>
			<?php endforeach; ?>
		</div>

	</div>
</section>
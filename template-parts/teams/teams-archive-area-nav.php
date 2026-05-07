<?php
/**
 * Teams archive area navigation.
 *
 * @package newinlife
 */

defined( 'ABSPATH' ) || exit;

$container = function_exists( 'inlife_container_class' ) ? inlife_container_class() : 'container';

$area_order = array(
	'zywnosc'   => inlife_t( 'Żywność' ),
	'zwierzeta' => inlife_t( 'Zwierzęta' ),
	'zdrowie'  => inlife_t( 'Zdrowie' ),
);
?>

<section class="teams-area-nav research-area-switcher" data-team-filters aria-label="<?php echo esc_attr( inlife_t( 'Filtruj zespoły według obszaru badawczego' ) ); ?>">
	<div class="<?php echo esc_attr( $container ); ?>">

		<div class="research-area-switcher__reset">
			<button
				type="button"
				class="research-area-switcher__all is-active"
				data-team-filter="all"
				aria-pressed="true"
			>
				<?php echo esc_html( inlife_t( 'Wszystkie zespoły' ) ); ?>
			</button>
		</div>

		<div class="research-area-switcher__grid">
			<?php foreach ( $area_order as $slug => $fallback_label ) : ?>
				<?php
				$term = get_term_by( 'slug', $slug, 'team_area' );

				if ( ! $term || is_wp_error( $term ) ) {
					continue;
				}

				$area_class = 'research-area-switcher__item--' . sanitize_html_class( $term->slug );
				?>
				<button
					type="button"
					class="research-area-switcher__item <?php echo esc_attr( $area_class ); ?>"
					data-team-filter="<?php echo esc_attr( $term->slug ); ?>"
					aria-pressed="false"
				>
					<span class="research-area-switcher__label">
						<?php echo esc_html( $term->name ?: $fallback_label ); ?>
					</span>
					<span class="research-area-switcher__arrow" aria-hidden="true">→</span>
				</button>
			<?php endforeach; ?>
		</div>

	</div>
</section>
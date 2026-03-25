<?php
/**
 * Teams archive header.
 *
 * @package newinlife
 */

defined( 'ABSPATH' ) || exit;
?>

<section class="teams-archive-header section">
	<div class="container">

		<div class="row align-items-center g-5">

			<div class="col-lg-6">
				<p class="section-eyebrow">
					<?php echo esc_html( inlife_t( 'Badania' ) ); ?>
				</p>

				<h1 class="section-title">
					<?php echo esc_html( inlife_t( 'Zespoły badawcze' ) ); ?>
				</h1>

				<p class="section-lead">
					<?php echo esc_html( inlife_t( 'Poznaj zespoły badawcze realizujące projekty w obszarach żywności, zdrowia oraz nauk o zwierzętach.' ) ); ?>
				</p>
			</div>

			<div class="col-lg-6">
				<div class="teams-archive-header__visual">
					<?php
					$area_order = array( 'zywnosc', 'zwierzeta', 'zdrowie' );

					foreach ( $area_order as $slug ) :
						$term = get_term_by( 'slug', $slug, 'team_area' );

						if ( ! $term || is_wp_error( $term ) ) {
							continue;
						}
						?>
						<div class="teams-archive-header__visual-card">
							<?php echo esc_html( $term->name ); ?>
						</div>
					<?php endforeach; ?>
				</div>
			</div>

		</div>

	</div>
</section>
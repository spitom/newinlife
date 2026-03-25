<?php
defined( 'ABSPATH' ) || exit;

$team_description = function_exists( 'get_field' ) ? get_field( 'team_description' ) : '';
?>

<div class="team-overview">
	<div class="row g-4 g-xl-5">

		<div class="col-lg-8">
			<div class="team-overview__main">
				<header class="section-heading">
					<h2 class="section-title"><?php echo esc_html( inlife_t( 'Opis działalności' ) ); ?></h2>
				</header>

				<div class="team-overview__content entry-content">
					<?php
					if ( $team_description ) {
						echo wp_kses_post( $team_description );
					} else {
						the_content();
					}
					?>
				</div>
			</div>
		</div>

		<div class="col-lg-4">
			<aside class="team-overview__aside">
				<div class="team-info-card">
					<h3 class="team-info-card__title"><?php echo esc_html( inlife_t( 'Profil jednostki' ) ); ?></h3>
					<p class="team-info-card__text">
						<?php echo esc_html( inlife_t( 'Szczegółowe informacje o zakresie działalności zespołu zostaną uzupełnione w kolejnym etapie wdrożenia.' ) ); ?>
					</p>
				</div>

				<div class="team-info-card">
					<h3 class="team-info-card__title"><?php echo esc_html( inlife_t( 'Obszary badawcze' ) ); ?></h3>
					<p class="team-info-card__text">
						<?php echo esc_html( inlife_t( 'Ta sekcja będzie rozwijana wraz z docelowymi polami i treściami redakcyjnymi.' ) ); ?>
					</p>
				</div>
			</aside>
		</div>

	</div>
</div>
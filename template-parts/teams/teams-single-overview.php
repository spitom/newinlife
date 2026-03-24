<?php
defined( 'ABSPATH' ) || exit;
?>

<div class="team-overview">
	<div class="row g-4 g-xl-5">

		<div class="col-lg-8">
			<div class="team-overview__main">
				<header class="section-heading">
					<h2 class="section-title"><?php esc_html_e( 'Opis działalności', 'newinlife' ); ?></h2>
				</header>

				<div class="team-overview__content entry-content">
					<?php the_content(); ?>
				</div>
			</div>
		</div>

		<div class="col-lg-4">
			<aside class="team-overview__aside">
				<div class="team-info-card">
					<h3 class="team-info-card__title"><?php esc_html_e( 'Profil jednostki', 'newinlife' ); ?></h3>
					<p class="team-info-card__text">
						<?php esc_html_e( 'Szczegółowe informacje o zakresie działalności zespołu zostaną uzupełnione w kolejnym etapie wdrożenia.', 'newinlife' ); ?>
					</p>
				</div>

				<div class="team-info-card">
					<h3 class="team-info-card__title"><?php esc_html_e( 'Obszary badawcze', 'newinlife' ); ?></h3>
					<p class="team-info-card__text">
						<?php esc_html_e( 'Ta sekcja będzie rozwijana wraz z docelowymi polami i treściami redakcyjnymi.', 'newinlife' ); ?>
					</p>
				</div>
			</aside>
		</div>

	</div>
</div>
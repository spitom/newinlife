<?php
$teams = function_exists( 'inlife_get_teams_for_person' )
	? inlife_get_teams_for_person( get_the_ID() )
	: array();
?>

<section class="person-relations person-relations--teams">
	<header class="person-relations__header">
		<h2 class="section-title">Zespoły</h2>
	</header>

	<?php if ( ! empty( $teams ) ) : ?>

		<div class="row g-4">

			<?php foreach ( $teams as $team ) : ?>
				<div class="col-md-6 col-xl-4">

					<article class="relation-card">
						<h3 class="relation-card__title">
							<a href="<?php echo esc_url( get_permalink( $team->ID ) ); ?>">
								<?php echo esc_html( get_the_title( $team->ID ) ); ?>
							</a>
						</h3>
					</article>

				</div>
			<?php endforeach; ?>

		</div>

	<?php else : ?>

		<div class="team-empty-state">
			<p>Brak przypisanych zespołów.</p>
		</div>

	<?php endif; ?>
</section>
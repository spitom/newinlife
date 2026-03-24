<?php
$labs = function_exists( 'inlife_get_laboratories_for_person' )
	? inlife_get_laboratories_for_person( get_the_ID() )
	: array();
?>

<section class="person-relations person-relations--laboratories">
	<header class="person-relations__header">
		<h2 class="section-title">Laboratoria</h2>
	</header>

	<?php if ( ! empty( $labs ) ) : ?>

		<div class="row g-4">

			<?php foreach ( $labs as $lab ) : ?>
				<div class="col-md-6 col-xl-4">

					<article class="relation-card">
						<h3 class="relation-card__title">
							<a href="<?php echo esc_url( get_permalink( $lab->ID ) ); ?>">
								<?php echo esc_html( get_the_title( $lab->ID ) ); ?>
							</a>
						</h3>
					</article>

				</div>
			<?php endforeach; ?>

		</div>

	<?php else : ?>

		<div class="team-empty-state">
			<p>Brak przypisanych laboratoriów.</p>
		</div>

	<?php endif; ?>
</section>
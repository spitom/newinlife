<?php
$data = function_exists( 'inlife_get_laboratory_people' )
	? inlife_get_laboratory_people( get_the_ID() )
	: array();

$all = $data['all'] ?? array();
?>

<section class="lab-people section">
	<div class="container">

		<h2 class="section-title">
			Skład osobowy
		</h2>

		<?php if ( ! empty( $all ) ) : ?>

			<div class="row g-4">

				<?php foreach ( $all as $person ) : ?>
					<?php
					$id   = $person->ID;
					$name = get_the_title( $id );
					$link = get_permalink( $id );
					$role = function_exists( 'get_field' ) ? get_field( 'position', $id ) : '';
					$img  = get_the_post_thumbnail( $id, 'medium', [ 'class' => 'person-card__image' ] );

					$is_manager = function_exists( 'inlife_is_person_manager_in_laboratory' )
						? inlife_is_person_manager_in_laboratory( $id, get_the_ID() )
						: false;
					?>

					<div class="col-md-6 col-xl-4">
						<article class="person-card <?php echo $is_manager ? 'person-card--manager' : ''; ?>">

							<div class="person-card__media">
								<?php echo $img ?: '<div class="person-card__photo"></div>'; ?>
							</div>

							<div class="person-card__content">

								<?php if ( $is_manager ) : ?>
									<span class="person-card__badge">
										Kierownik laboratorium
									</span>
								<?php endif; ?>

								<h3 class="person-card__name">
									<?php echo esc_html( $name ); ?>
								</h3>

								<?php if ( $role ) : ?>
									<p class="person-card__role">
										<?php echo esc_html( $role ); ?>
									</p>
								<?php endif; ?>

								<a href="<?php echo esc_url( $link ); ?>" class="person-card__link">
									Zobacz profil →
								</a>

							</div>

						</article>
					</div>

				<?php endforeach; ?>

			</div>

		<?php else : ?>

			<div class="team-empty-state">
				<p>Skład osobowy nie został jeszcze uzupełniony.</p>
			</div>

		<?php endif; ?>

	</div>
</section>
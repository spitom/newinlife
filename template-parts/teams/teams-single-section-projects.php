<?php
defined( 'ABSPATH' ) || exit;
?>

<div class="team-section-block team-section-block--projects c-surface c-surface--panel">
	<header class="section-heading">
		<h2 class="section-title">
			<?php echo esc_html( inlife_t( 'Aktualne projekty' ) ); ?>
		</h2>
	</header>

	<?php if ( function_exists( 'have_rows' ) && have_rows( 'team_projects' ) ) : ?>

		<div class="team-projects-list">
			<?php
			while ( have_rows( 'team_projects' ) ) :
				the_row();

				$content = get_sub_field( 'project_content' );
				$role    = get_sub_field( 'project_role_label' );
				$person  = get_sub_field( 'project_person' );
				$url     = get_sub_field( 'project_url' );

				$person_id = $person ? $person->ID : null;

				if ( ! $content && ! $role && ! $person_id && ! $url ) {
					continue;
				}

				$name = $person_id
					? ( function_exists( 'inlife_get_person_display_name' )
						? inlife_get_person_display_name( $person_id )
						: get_the_title( $person_id ) )
					: '';

				$link = $person_id ? get_permalink( $person_id ) : '';
			?>
				<article class="team-project-item">

					<?php if ( $role || $name ) : ?>
						<div class="team-project-item__meta">

							<?php if ( $role ) : ?>
								<span class="team-project-item__role">
									<?php echo esc_html( $role ); ?>
								</span>
							<?php endif; ?>

							<?php if ( $name ) : ?>
								<span class="team-project-item__person">
									<?php if ( $link ) : ?>
										<a href="<?php echo esc_url( $link ); ?>">
											<?php echo esc_html( $name ); ?>
										</a>
									<?php else : ?>
										<?php echo esc_html( $name ); ?>
									<?php endif; ?>
								</span>
							<?php endif; ?>

						</div>
					<?php endif; ?>

					<?php if ( $content ) : ?>
						<div class="team-project-item__content entry-content">
							<?php echo wp_kses_post( $content ); ?>
						</div>
					<?php endif; ?>

					<?php if ( $url ) : ?>
						<a href="<?php echo esc_url( $url ); ?>" class="team-project-item__link c-readmore">
							<span class="c-readmore__label">
								<?php echo esc_html( inlife_t( 'Zobacz projekt' ) ); ?>
							</span>
							<span class="c-readmore__icon" aria-hidden="true">→</span>
						</a>
					<?php endif; ?>

				</article>
			<?php endwhile; ?>
		</div>

	<?php else : ?>

		<div class="team-empty-state">
			<p><?php echo esc_html( inlife_t( 'Sekcja projektów nie została jeszcze uzupełniona.' ) ); ?></p>
		</div>

	<?php endif; ?>
</div>
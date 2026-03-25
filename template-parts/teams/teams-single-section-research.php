<?php
defined( 'ABSPATH' ) || exit;
?>

<div class="team-section-block">
	<header class="section-heading">
		<h2 class="section-title"><?php echo esc_html( inlife_t( 'Badania' ) ); ?></h2>
	</header>

	<?php if ( function_exists( 'have_rows' ) && have_rows( 'team_research_items' ) ) : ?>

		<div class="team-feature-grid">
			<?php while ( have_rows( 'team_research_items' ) ) : the_row(); ?>
				<?php
				$title = get_sub_field( 'title' );
				$desc  = get_sub_field( 'description' );
				?>

				<?php if ( $title || $desc ) : ?>
					<article class="team-feature-card">
						<?php if ( $title ) : ?>
							<h3 class="team-feature-card__title">
								<?php echo esc_html( $title ); ?>
							</h3>
						<?php endif; ?>

						<?php if ( $desc ) : ?>
							<p class="team-feature-card__text">
								<?php echo esc_html( $desc ); ?>
							</p>
						<?php endif; ?>
					</article>
				<?php endif; ?>
			<?php endwhile; ?>
		</div>

	<?php else : ?>

		<div class="team-empty-state">
			<p><?php esc_html_e( 'Sekcja badań nie została jeszcze uzupełniona.', 'newinlife' ); ?></p>
		</div>

	<?php endif; ?>
</div>
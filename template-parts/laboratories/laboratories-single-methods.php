<?php
defined( 'ABSPATH' ) || exit;
?>

<div class="lab-section-block">
	<header class="section-heading">
		<h2 class="section-title"><?php echo esc_html( inlife_t( 'Oferowane metody i analizy' ) ); ?></h2>
	</header>

	<?php if ( function_exists( 'have_rows' ) && have_rows( 'laboratory_methods' ) ) : ?>

		<div class="lab-methods-grid">
			<?php while ( have_rows( 'laboratory_methods' ) ) : the_row(); ?>
				<?php
				$title = get_sub_field( 'title' );
				$desc  = get_sub_field( 'description' );
				?>

				<?php if ( $title || $desc ) : ?>
					<article class="lab-method-card">
						<?php if ( $title ) : ?>
							<h3 class="lab-method-card__title">
								<?php echo esc_html( $title ); ?>
							</h3>
						<?php endif; ?>

						<?php if ( $desc ) : ?>
							<p class="lab-method-card__text">
								<?php echo esc_html( $desc ); ?>
							</p>
						<?php endif; ?>
					</article>
				<?php endif; ?>
			<?php endwhile; ?>
		</div>

	<?php else : ?>

		<div class="team-empty-state">
			<p><?php esc_html_e( 'Sekcja metod i analiz nie została jeszcze uzupełniona.', 'newinlife' ); ?></p>
		</div>

	<?php endif; ?>
</div>
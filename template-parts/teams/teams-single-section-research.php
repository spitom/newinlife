<?php
defined( 'ABSPATH' ) || exit;
?>

<div class="team-section-block team-section-block--research c-surface c-surface--panel">
	<header class="section-heading">
		<h2 class="section-title"><?php echo esc_html( inlife_t( 'Osiągnięcia naukowe' ) ); ?></h2>
	</header>

	<?php if ( function_exists( 'have_rows' ) && have_rows( 'team_research_items' ) ) : ?>

		<div class="team-achievements-list">
			<?php
			$index = 1;

			while ( have_rows( 'team_research_items' ) ) :
				the_row();

				$title = get_sub_field( 'title' );
				$desc  = get_sub_field( 'description' );

				if ( ! $title && ! $desc ) {
					continue;
				}
				?>
				<article class="team-achievement-item">
					<div class="team-achievement-item__number" aria-hidden="true">
						<?php echo esc_html( str_pad( (string) $index, 2, '0', STR_PAD_LEFT ) ); ?>
					</div>

					<div class="team-achievement-item__content">
						<?php if ( $title ) : ?>
							<h3 class="team-achievement-item__title">
								<?php echo esc_html( $title ); ?>
							</h3>
						<?php endif; ?>

						<?php if ( $desc ) : ?>
							<div class="team-achievement-item__text entry-content">
								<?php echo wpautop( wp_kses_post( $desc ) ); ?>
							</div>
						<?php endif; ?>
					</div>
				</article>
				<?php
				$index++;
			endwhile;
			?>
		</div>

	<?php else : ?>

		<div class="team-empty-state">
			<p><?php echo esc_html( inlife_t( 'Sekcja osiągnięć naukowych nie została jeszcze uzupełniona.' ) ); ?></p>
		</div>

	<?php endif; ?>
</div>
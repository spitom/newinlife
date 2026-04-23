<?php
defined( 'ABSPATH' ) || exit;
?>

<div class="lab-section-block lab-section-block--equipment c-surface c-surface--panel">
	<header class="section-heading">
		<h2 class="section-title"><?php echo esc_html( inlife_t( 'Wyposażenie laboratorium' ) ); ?></h2>
	</header>

	<?php if ( function_exists( 'have_rows' ) && have_rows( 'laboratory_equipment' ) ) : ?>

		<div class="lab-equipment-items">
			<?php
			while ( have_rows( 'laboratory_equipment' ) ) :
				the_row();

				$name = get_sub_field( 'name' );
				$desc = get_sub_field( 'description' );

				if ( ! $name && ! $desc ) {
					continue;
				}
				?>
				<article class="lab-equipment-item">
					<?php if ( $name ) : ?>
						<h3 class="lab-equipment-item__name">
							<?php echo esc_html( $name ); ?>
						</h3>
					<?php endif; ?>

					<?php if ( $desc ) : ?>
						<div class="lab-equipment-item__text entry-content">
							<?php echo wp_kses_post( $desc ); ?>
						</div>
					<?php endif; ?>
				</article>
			<?php endwhile; ?>
		</div>

	<?php else : ?>

		<div class="team-empty-state">
			<p><?php echo esc_html( inlife_t( 'Sekcja wyposażenia nie została jeszcze uzupełniona.' ) ); ?></p>
		</div>

	<?php endif; ?>
</div>
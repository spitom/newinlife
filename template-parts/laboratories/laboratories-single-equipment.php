<?php
defined( 'ABSPATH' ) || exit;
?>

<div class="lab-section-block">
	<header class="section-heading">
		<h2 class="section-title"><?php echo esc_html( inlife_t( 'Wyposażenie laboratorium' ) ); ?></h2>
	</header>

	<?php if ( function_exists( 'have_rows' ) && have_rows( 'laboratory_equipment' ) ) : ?>

		<div class="lab-equipment-list">
			<ul>
				<?php while ( have_rows( 'laboratory_equipment' ) ) : the_row(); ?>
					<?php
					$name = get_sub_field( 'name' );
					$desc = get_sub_field( 'description' );
					?>

					<?php if ( $name ) : ?>
						<li>
							<strong><?php echo esc_html( $name ); ?></strong>
							<?php if ( $desc ) : ?>
								 – <?php echo esc_html( $desc ); ?>
							<?php endif; ?>
						</li>
					<?php endif; ?>

				<?php endwhile; ?>
			</ul>
		</div>

	<?php else : ?>

		<div class="team-empty-state">
			<p><?php esc_html_e( 'Sekcja wyposażenia nie została jeszcze uzupełniona.', 'newinlife' ); ?></p>
		</div>

	<?php endif; ?>
</div>
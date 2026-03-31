<?php
defined( 'ABSPATH' ) || exit;
?>

<div class="lab-section-block lab-section-block--methods">
	<header class="section-heading">
		<h2 class="section-title"><?php echo esc_html( inlife_t( 'Oferowane metody i analizy' ) ); ?></h2>
	</header>

	<?php if ( function_exists( 'have_rows' ) && have_rows( 'laboratory_methods' ) ) : ?>

		<div class="lab-methods-list">
			<?php
			$index = 1;

			while ( have_rows( 'laboratory_methods' ) ) :
				the_row();

				$title = get_sub_field( 'title' );
				$desc  = get_sub_field( 'description' );

				if ( ! $title && ! $desc ) {
					continue;
				}
				?>
				<article class="lab-method-item">
					<div class="lab-method-item__number" aria-hidden="true">
						<?php echo esc_html( str_pad( (string) $index, 2, '0', STR_PAD_LEFT ) ); ?>
					</div>

					<div class="lab-method-item__content">
						<?php if ( $title ) : ?>
							<h3 class="lab-method-item__title">
								<?php echo esc_html( $title ); ?>
							</h3>
						<?php endif; ?>

						<?php if ( $desc ) : ?>
							<div class="lab-method-item__text entry-content">
								<?php echo wp_kses_post( $desc ); ?>
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
			<p><?php echo esc_html( inlife_t( 'Sekcja metod i analiz nie została jeszcze uzupełniona.' ) ); ?></p>
		</div>

	<?php endif; ?>
</div>
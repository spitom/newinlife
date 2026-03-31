<?php
defined('ABSPATH') || exit;
?>

<div class="research-section research-section--areas">
	<div class="row g-4 align-items-end">
		<div class="col-lg-8">
			<div class="section-heading mb-0">
				<p class="section-kicker"><?php echo esc_html( inlife_t( 'Kierunki badań' ) ); ?></p>
				<h2 id="research-areas-heading" class="section-title"><?php echo esc_html( inlife_t( 'Obszary działania' ) ); ?></h2>
			</div>

			<p class="section-lead mt-3 mb-0">
				<?php echo esc_html( inlife_t( 'Główne obszary badawcze.' ) ); ?>
			</p>
		</div>

		<div class="col-lg-4 text-lg-end">
			<a href="#" class="research-pill-link"><?php echo esc_html( inlife_t( 'Zobacz wszystkie obszary' ) ); ?></a>
		</div>
	</div>

	<div class="row g-4 mt-1">
		<?php for ( $i = 1; $i <= 4; $i++ ) : ?>
			<div class="col-md-6 col-xl-3">
				<article class="research-area-card h-100">
					<div class="research-area-card__body">
						<span class="research-area-card__badge"><?php echo esc_html( '0' . $i ); ?></span>

						<h3 class="research-area-card__title">
							<?php echo esc_html( inlife_t( 'Obszar' ) . ' ' . $i ); ?>
						</h3>

						<p class="research-area-card__text">
							<?php echo esc_html( inlife_t( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut euismod elementum nisl, vitae iaculis justo.' ) ); ?>
						</p>

						<a href="#" class="research-inline-link">
							<?php echo esc_html( inlife_t( 'Przejdź do obszaru' ) ); ?> <span aria-hidden="true">→</span>
						</a>
					</div>
				</article>
			</div>
		<?php endfor; ?>
	</div>
</div>
<?php
defined( 'ABSPATH' ) || exit;

$container = inlife_container_class();
?>

<section id="hero" class="front-section front-hero" aria-labelledby="hero-heading">
	<div class="<?php echo esc_attr( $container ); ?>">
		<div class="front-hero__inner">
			<div class="row align-items-end g-4">
				<div class="col-xl-8">
					<p class="front-hero__eyebrow">InLife Institute</p>
					<h1 id="hero-heading" class="front-hero__title">
						Nagłówek hero / slider
					</h1>
					<p class="front-hero__lead">
						Miejsce na główny komunikat strony głównej. Docelowo pod slider lub statyczny hero.
					</p>
				</div>

				<div class="col-xl-4">
					<div class="front-hero__aside">
						Tutaj może wejść skrót do ważnej sekcji, CTA albo panel boczny.
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
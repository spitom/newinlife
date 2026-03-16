<?php
defined( 'ABSPATH' ) || exit;

$container = inlife_container_class();
?>

<section id="news" class="front-section front-news" aria-labelledby="news-heading">
	<div class="<?php echo esc_attr( $container ); ?>">
		<div class="section-heading d-flex justify-content-between align-items-end gap-3 flex-wrap">
			<div>
				<h2 id="news-heading" class="section-title">Aktualności</h2>
			</div>
			<a href="#" class="btn btn-outline-primary">Wszystkie aktualności</a>
		</div>

		<div class="row g-4">
			<div class="col-lg-4">
				<div class="card card-news h-100">
					<div class="card-body">
						<div class="news-tags mb-3">
							<span class="badge text-bg-light">Nauka</span>
						</div>
						<h3 class="h5">Przykładowy news</h3>
						<p class="mb-0">Miejsce na lead aktualności.</p>
					</div>
				</div>
			</div>

			<div class="col-lg-4">
				<div class="card card-news h-100">
					<div class="card-body">
						<div class="news-tags mb-3">
							<span class="badge text-bg-light">Badania</span>
						</div>
						<h3 class="h5">Przykładowy news</h3>
						<p class="mb-0">Miejsce na lead aktualności.</p>
					</div>
				</div>
			</div>

			<div class="col-lg-4">
				<div class="card card-news h-100">
					<div class="card-body">
						<div class="news-tags mb-3">
							<span class="badge text-bg-light">Instytut</span>
						</div>
						<h3 class="h5">Przykładowy news</h3>
						<p class="mb-0">Miejsce na lead aktualności.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php
defined('ABSPATH') || exit;
?>

<div class="research-section research-section--projects">

	<!-- 🔹 HEADER SEKJI -->
	<div class="row g-4 align-items-end">
		<div class="col-lg-8">
			<div class="section-heading mb-0">
				<p class="section-kicker">
					<?php echo esc_html( inlife_t( 'Finansowanie i rozwój' ) ); ?>
				</p>

				<h2 id="research-projects-heading" class="section-title">
					<?php echo esc_html( inlife_t( 'Projekty' ) ); ?>
				</h2>
			</div>

			<p class="section-lead mt-3 mb-0">
				<?php echo esc_html( inlife_t( 'Zajawka katalogu projektów z podziałem na główne programy i źródła finansowania.' ) ); ?>
			</p>
		</div>

		<div class="col-lg-4 text-lg-end">
			<a href="/projekty" class="btn btn-outline-primary">
				<?php echo esc_html( inlife_t( 'Zobacz wszystkie projekty' ) ); ?>
			</a>
		</div>
	</div>

	<!-- 🔹 CONTENT -->
	<div class="research-projects-grid">

		<div class="research-project-col">
			<h3><?php echo esc_html( inlife_t( 'Fundusze europejskie' ) ); ?></h3>
			<ul>
				<li>Horizon Europe</li>
				<li>Interreg</li>
				<li>Programy strukturalne</li>
			</ul>
		</div>

		<div class="research-project-col">
			<h3><?php echo esc_html( inlife_t( 'NCBiR / NCN' ) ); ?></h3>
			<ul>
				<li>OPUS</li>
				<li>PRELUDIUM</li>
				<li>SONATA</li>
			</ul>
		</div>

		<div class="research-project-col">
			<h3><?php echo esc_html( inlife_t( 'Granty krajowe' ) ); ?></h3>
			<ul>
				<li>Ministerialne</li>
				<li>Programy własne</li>
				<li>Współpraca przemysłowa</li>
			</ul>
		</div>

	</div>

</div>
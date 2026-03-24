<section class="lab-hero section">
	<div class="container">

		<div class="row align-items-center g-5">

			<div class="col-lg-6">

				<p class="section-eyebrow">Badania</p>

				<h1 class="lab-hero__title">
					<?php the_title(); ?>
				</h1>

				<p class="lab-hero__lead">
					<?php echo wp_trim_words( get_the_excerpt(), 25 ); ?>
				</p>

			</div>

			<div class="col-lg-6">

				<div class="lab-hero__visual">
					<span>Laboratorium</span>
				</div>

			</div>

		</div>

	</div>
</section>
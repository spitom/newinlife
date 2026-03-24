<section class="teams-grid section">
	<div class="container">

		<div class="row g-4">

			<?php for ($i = 0; $i < 6; $i++) : ?>
				<div class="col-md-6 col-xl-4">
					<?php get_template_part('template-parts/teams/teams', 'card'); ?>
				</div>
			<?php endfor; ?>

		</div>

	</div>
</section>
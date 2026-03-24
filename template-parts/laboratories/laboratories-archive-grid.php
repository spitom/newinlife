<section class="laboratories-grid section">
	<div class="container">

		<?php if ( have_posts() ) : ?>

			<div class="row g-4">

				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<div class="col-md-6 col-xl-4">
						<?php get_template_part( 'template-parts/laboratories/laboratories', 'card' ); ?>
					</div>
				<?php endwhile; ?>

			</div>

		<?php else : ?>

			<div class="team-empty-state">
				<p>Lista laboratoriów zostanie uzupełniona wkrótce.</p>
			</div>

		<?php endif; ?>

	</div>
</section>
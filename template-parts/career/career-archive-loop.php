<?php
defined('ABSPATH') || exit;
?>

<?php if (have_posts()) : ?>
	<div class="career-archive-list">
		<?php while (have_posts()) : the_post(); ?>
			<?php get_template_part('template-parts/career/career-archive', 'card'); ?>
		<?php endwhile; ?>
	</div>

	<?php the_posts_pagination(); ?>
<?php else : ?>
	<div class="career-op-empty">
		<p class="career-op-empty__text">Brak wpisów spełniających kryteria.</p>
	</div>
<?php endif; ?>
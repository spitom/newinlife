<?php
defined( 'ABSPATH' ) || exit;
?>

<?php if ( have_posts() ) : ?>
	<div class="people-directory">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'template-parts/people/people', 'card' ); ?>
		<?php endwhile; ?>
	</div>

	<div class="people-pagination">
		<?php
		the_posts_pagination(
			[
				'mid_size'  => 1,
				'prev_text' => __( 'Poprzednia', 'newinlife' ),
				'next_text' => __( 'Następna', 'newinlife' ),
			]
		);
		?>
	</div>
<?php else : ?>
	<div class="people-empty">
		<p class="people-empty__text">
			<?php esc_html_e( 'Nie znaleziono osób spełniających wybrane kryteria.', 'newinlife' ); ?>
		</p>
	</div>
<?php endif; ?>
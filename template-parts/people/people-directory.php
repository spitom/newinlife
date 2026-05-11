<?php
defined( 'ABSPATH' ) || exit;
?>

<?php if ( have_posts() ) : ?>
	<div class="people-directory-list">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'template-parts/people/people', 'list-item' ); ?>
		<?php endwhile; ?>
	</div>

	<div class="people-pagination">
		<?php
		the_posts_pagination(
			[
				'mid_size'  => 1,
				'prev_text' => inlife_t( 'Poprzednia' ),
				'next_text' => inlife_t( 'Następna' ),
			]
		);
		?>
	</div>
<?php else : ?>
	<div class="people-empty">
		<p class="people-empty__text">
			<?php echo esc_html( inlife_t( 'Nie znaleziono osób spełniających wybrane kryteria.' ) ); ?>
		</p>
	</div>
<?php endif; ?>
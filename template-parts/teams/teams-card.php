<?php
$terms = get_the_terms( get_the_ID(), 'team_area' );
$area  = $terms && ! is_wp_error( $terms ) ? $terms[0]->name : '';
?>

<article class="team-card">

	<div class="team-card__inner">

		<?php if ( $area ) : ?>
			<span class="team-card__area">
				<?php echo esc_html( $area ); ?>
			</span>
		<?php endif; ?>

		<h3 class="team-card__title">
			<?php the_title(); ?>
		</h3>

		<div class="team-card__excerpt">
			<?php echo wp_trim_words( get_the_excerpt(), 20 ); ?>
		</div>

		<a href="<?php the_permalink(); ?>" class="team-card__link">
			Zobacz zespół →
		</a>

	</div>

</article>
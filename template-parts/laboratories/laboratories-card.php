<?php
$excerpt = get_the_excerpt();
?>

<article class="laboratory-card">

	<div class="laboratory-card__inner">

		<div class="laboratory-card__visual" aria-hidden="true">
			<span>Laboratorium</span>
		</div>

		<h2 class="laboratory-card__title">
			<a href="<?php the_permalink(); ?>" class="laboratory-card__title-link">
				<?php the_title(); ?>
			</a>
		</h2>

		<div class="laboratory-card__excerpt">
			<?php
			if ( $excerpt ) {
				echo esc_html( wp_trim_words( $excerpt, 20 ) );
			} else {
				echo esc_html__( 'Profil laboratorium zostanie wkrótce uzupełniony.', 'newinlife' );
			}
			?>
		</div>

		<a href="<?php the_permalink(); ?>" class="laboratory-card__link">
			Zobacz laboratorium →
		</a>

	</div>

</article>
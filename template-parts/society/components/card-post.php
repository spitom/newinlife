<?php
defined( 'ABSPATH' ) || exit;

$post_id = $args['post_id'] ?? 0;

if ( ! $post_id ) {
	return;
}

$terms = get_the_terms( $post_id, 'society_format' );
$badge = '';

if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
	$term = reset( $terms );

	$map = [
		'zobacz'              => inlife_t( 'Zobacz' ),
		'posluchaj'           => inlife_t( 'Posłuchaj' ),
		'przeczytaj'          => inlife_t( 'Przeczytaj' ),
		'spotkaj-sie-z-nami'  => inlife_t( 'Spotkaj się z nami' ),
	];

	$badge = $map[ $term->slug ] ?? $term->name;
}
?>

<article class="society-card society-card--post">
	<?php if ( has_post_thumbnail( $post_id ) ) : ?>
		<a class="society-card__media" href="<?php echo esc_url( get_permalink( $post_id ) ); ?>" aria-hidden="true" tabindex="-1">
			<?php echo get_the_post_thumbnail( $post_id, 'medium_large', [ 'class' => 'img-fluid' ] ); ?>
		</a>
	<?php endif; ?>

	<div class="society-card__body">
		<?php if ( $badge ) : ?>
			<p class="society-card__badge"><?php echo esc_html( $badge ); ?></p>
		<?php endif; ?>

		<h3 class="society-card__title">
			<a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>">
				<?php echo esc_html( get_the_title( $post_id ) ); ?>
			</a>
		</h3>

		<?php if ( has_excerpt( $post_id ) ) : ?>
			<div class="society-card__text">
				<p><?php echo esc_html( get_the_excerpt( $post_id ) ); ?></p>
			</div>
		<?php endif; ?>

		<a class="society-card__link" href="<?php echo esc_url( get_permalink( $post_id ) ); ?>">
			<?php echo esc_html( inlife_t( 'Zobacz więcej' ) ); ?>
		</a>
	</div>
</article>
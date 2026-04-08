<?php
defined( 'ABSPATH' ) || exit;

$post_id = $args['post_id'] ?? 0;

if ( ! $post_id ) {
	return;
}

$title     = get_field( 'initiative_title', $post_id );
$lead      = get_field( 'initiative_card_text', $post_id );
$permalink = get_permalink( $post_id );

$title = $title ?: get_the_title( $post_id );
?>

<article class="society-card society-card--initiative">
	<?php if ( has_post_thumbnail( $post_id ) ) : ?>
		<a class="society-card__media" href="<?php echo esc_url( $permalink ); ?>" aria-hidden="true" tabindex="-1">
			<?php echo get_the_post_thumbnail( $post_id, 'medium_large', [ 'class' => 'img-fluid' ] ); ?>
		</a>
	<?php endif; ?>

	<div class="society-card__body">
		<h3 class="society-card__title">
			<a href="<?php echo esc_url( $permalink ); ?>">
				<?php echo esc_html( $title ); ?>
			</a>
		</h3>

		<?php if ( $lead ) : ?>
			<div class="society-card__text">
				<p><?php echo esc_html( $lead ); ?></p>
			</div>
		<?php endif; ?>

		<a class="society-card__link" href="<?php echo esc_url( $permalink ); ?>">
			<?php echo esc_html( inlife_t( 'Zobacz więcej' ) ); ?>
		</a>
	</div>
</article>
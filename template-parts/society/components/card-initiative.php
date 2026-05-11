<?php
/**
 * Society initiative card
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

$post_id = $args['post_id'] ?? 0;

if ( ! $post_id ) {
	return;
}

$permalink = get_permalink( $post_id );
$title     = function_exists( 'get_field' ) ? get_field( 'initiative_title', $post_id ) : '';
$lead      = function_exists( 'get_field' ) ? get_field( 'initiative_card_text', $post_id ) : '';

$title = $title ?: get_the_title( $post_id );

if ( ! $permalink || ! $title ) {
	return;
}
?>

<article class="society-link-item">
	<a class="society-link-item__link" href="<?php echo esc_url( $permalink ); ?>">
		<div class="society-link-item__content">
			<span class="society-link-item__eyebrow">
				<?php echo esc_html( inlife_t( 'Projekt' ) ); ?>
			</span>

			<h3 class="society-link-item__title">
				<?php echo esc_html( $title ); ?>
			</h3>

			<?php if ( $lead ) : ?>
				<p class="society-link-item__text">
					<?php echo esc_html( $lead ); ?>
				</p>
			<?php endif; ?>
		</div>

		<span class="society-link-item__readmore c-readmore">
			<?php echo esc_html( inlife_t( 'Przejdź dalej' ) ); ?>
			<span class="c-readmore__icon" aria-hidden="true">→</span>
		</span>
	</a>
</article>
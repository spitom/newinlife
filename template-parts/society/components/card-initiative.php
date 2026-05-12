<?php
/**
 * Society initiative card.
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

$title = $args['title'] ?? '';
$link  = $args['link'] ?? null;

$url    = is_array( $link ) && ! empty( $link['url'] ) ? $link['url'] : '';
$target = is_array( $link ) && ! empty( $link['target'] ) ? $link['target'] : '';
$label  = is_array( $link ) && ! empty( $link['title'] ) ? $link['title'] : inlife_t( 'Przejdź dalej' );

if ( '' === trim( (string) $title ) || '' === trim( (string) $url ) ) {
	return;
}
?>

<article class="society-link-item">
	<a
		class="society-link-item__link"
		href="<?php echo esc_url( $url ); ?>"
		<?php echo $target ? 'target="' . esc_attr( $target ) . '"' : ''; ?>
		aria-label="<?php echo esc_attr( $label . ': ' . $title ); ?>"
	>
		<div class="society-link-item__content">
			<h3 class="society-link-item__title">
				<?php echo esc_html( $title ); ?>
			</h3>
		</div>

		<span class="society-link-item__readmore" aria-hidden="true">
			<span class="society-link-item__arrow">→</span>
		</span>
	</a>
</article>
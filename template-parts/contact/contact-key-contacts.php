<?php
defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

$heading = inlife_get_acf_field(
	'contact_related_heading',
	$post_id,
	inlife_t( 'Powiązane informacje' )
);

$items = inlife_get_acf_field(
	'contact_related_items',
	$post_id,
	[]
);

if ( ! is_array( $items ) || empty( $items ) ) {
	return;
}
?>

<div class="contact-key-contacts">

	<div class="section-heading section-heading--center">
		<h2 id="contact-key-contacts-heading" class="section-title">
			<?php echo esc_html( $heading ); ?>
		</h2>
	</div>

	<div class="contact-key-contacts__list">

		<?php foreach ( $items as $item ) : ?>
			<?php
			$title = isset( $item['related_title'] )
				? trim( (string) $item['related_title'] )
				: '';

			$text = isset( $item['related_text'] )
				? trim( (string) $item['related_text'] )
				: '';

			$link = isset( $item['related_link'] ) && is_array( $item['related_link'] )
				? $item['related_link']
				: [];

			$url = isset( $link['url'] )
				? trim( (string) $link['url'] )
				: '';

			$link_title = isset( $link['title'] )
				? trim( (string) $link['title'] )
				: '';

			$target = isset( $link['target'] )
				? trim( (string) $link['target'] )
				: '';

			if ( '' === $title || '' === $url ) {
				continue;
			}

			if ( '' === $link_title ) {
				$link_title = inlife_t( 'Przejdź dalej' );
			}

			$rel = '_blank' === $target
				? 'noopener noreferrer'
				: '';
			?>

			<article class="contact-key-contacts__item">

				<h3 class="contact-key-contacts__title">
					<?php echo esc_html( $title ); ?>
				</h3>

				<?php if ( '' !== $text ) : ?>
					<p class="contact-key-contacts__text">
						<?php echo esc_html( $text ); ?>
					</p>
				<?php endif; ?>

				<a
					class="c-readmore contact-key-contacts__link"
					href="<?php echo esc_url( $url ); ?>"
					<?php if ( '' !== $target ) : ?>
						target="<?php echo esc_attr( $target ); ?>"
					<?php endif; ?>
					<?php if ( '' !== $rel ) : ?>
						rel="<?php echo esc_attr( $rel ); ?>"
					<?php endif; ?>
				>
					<?php echo esc_html( $link_title ); ?>
					<span class="c-readmore__icon" aria-hidden="true">→</span>
				</a>

			</article>

		<?php endforeach; ?>

	</div>

</div>
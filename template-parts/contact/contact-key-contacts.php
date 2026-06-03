<?php
defined( 'ABSPATH' ) || exit;

$key_contacts = [
	[
		'title' => inlife_t( 'Ludzie' ),
		'text'  => inlife_t( 'Katalog pracowników Instytutu.' ),
		'url'   => home_url( '/people/' ),
	],
	[
		'title' => inlife_t( 'Struktura organizacyjna' ),
		'text'  => inlife_t( 'Jednostki i odpowiedzialności.' ),
		'url'   => home_url( '/struktura/' ),
	],
	[
		'title' => inlife_t( 'Dla mediów' ),
		'text'  => inlife_t( 'Materiały prasowe i kontakt.' ),
		'url'   => home_url( '/dla-mediow/' ),
	],
];
?>

<div class="contact-key-contacts">

	<div class="section-heading section-heading--center">
		<h2 id="contact-key-contacts-heading" class="section-title">
			<?php echo esc_html( inlife_t( 'Powiązane informacje' ) ); ?>
		</h2>
	</div>

	<div class="contact-key-contacts__list">

		<?php foreach ( $key_contacts as $item ) : ?>
			<article class="contact-key-contacts__item">
				<h3 class="contact-key-contacts__title">
					<?php echo esc_html( $item['title'] ); ?>
				</h3>

				<p class="contact-key-contacts__text">
					<?php echo esc_html( $item['text'] ); ?>
				</p>

				<a class="c-readmore contact-key-contacts__link" href="<?php echo esc_url( $item['url'] ); ?>">
					<?php echo esc_html( inlife_t( 'Przejdź dalej' ) ); ?>
					<span class="c-readmore__icon" aria-hidden="true">→</span>
				</a>
			</article>
		<?php endforeach; ?>

	</div>

</div>
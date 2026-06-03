<?php
defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

$formal_items = [
	[
		'label' => 'NIP',
		'value' => inlife_get_acf_field( 'contact_nip', $post_id ),
	],
	[
		'label' => 'REGON',
		'value' => inlife_get_acf_field( 'contact_regon', $post_id ),
	],
	[
		'label' => 'Rejestr Instytutów Naukowych (RIN)',
		'value' => inlife_get_acf_field( 'contact_rin', $post_id ),
	],
	[
		'label' => 'EU Participant Identification Code (PIC)',
		'value' => inlife_get_acf_field( 'contact_pic', $post_id ),
	],
	[
		'label' => 'Identyfikator w ePUAP',
		'value' => inlife_get_acf_field( 'contact_epuap', $post_id ),
	],
	[
		'label' => inlife_t( 'e-Doręczenia' ),
		'value' => inlife_get_acf_field( 'contact_edoreczenia', $post_id ),
	],
];

$formal_items = array_filter(
	$formal_items,
	static fn( $item ) => ! empty( $item['value'] )
);

if ( empty( $formal_items ) ) {
	return;
}
?>

<div class="contact-formal">

	<div class="section-heading section-heading--center">
		<h2 id="contact-formal-heading" class="section-title">
			<?php echo esc_html( inlife_t( 'Dane instytucjonalne' ) ); ?>
		</h2>
	</div>

	<div class="contact-formal__grid">

		<?php foreach ( $formal_items as $item ) : ?>

			<div class="contact-formal__card">
				<div class="contact-formal__label">
					<?php echo esc_html( $item['label'] ); ?>
				</div>

				<div class="contact-formal__value">
					<?php echo esc_html( $item['value'] ); ?>
				</div>
			</div>

		<?php endforeach; ?>

	</div>

</div>
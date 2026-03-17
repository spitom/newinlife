<?php
defined( 'ABSPATH' ) || exit;

/**
 * Ustaw tutaj docelowy URL BIP.
 * Docelowo możesz to przenieść do opcji motywu / ACF options.
 */
$bip_url = 'https://bip.pan.olsztyn.pl';
?>

<a
	class="inlife-bip-link"
	href="<?php echo esc_url( $bip_url ); ?>"
	aria-label="<?php esc_attr_e( 'Biuletyn Informacji Publicznej', 'newinlife-child' ); ?>"
>
	<?php get_template_part( 'template-parts/icons/inlife-icon', 'bip' ); ?>
	<span class="visually-hidden">
		<?php esc_html_e( 'Biuletyn Informacji Publicznej', 'newinlife-child' ); ?>
	</span>
</a>
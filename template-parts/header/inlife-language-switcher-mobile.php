<?php
defined( 'ABSPATH' ) || exit;

$languages = inlife_get_languages();

if ( empty( $languages ) || ! is_array( $languages ) ) {
	return;
}

$target_language = null;

foreach ( $languages as $lang ) {
	if ( empty( $lang['current_lang'] ) ) {
		$target_language = $lang;
		break;
	}
}

if ( empty( $target_language ) ) {
	return;
}

$slug   = ! empty( $target_language['slug'] ) ? strtoupper( $target_language['slug'] ) : '';
$url    = ! empty( $target_language['url'] ) ? $target_language['url'] : '#';
$locale = ! empty( $target_language['locale'] ) ? $target_language['locale'] : strtolower( $target_language['slug'] );
?>

<nav class="language-switcher language-switcher--mobile-single" aria-label="<?php esc_attr_e( 'Zmień język', 'newinlife-child' ); ?>">
	<a
		class="language-switcher__link language-switcher__link--single"
		href="<?php echo esc_url( $url ); ?>"
		hreflang="<?php echo esc_attr( strtolower( $target_language['slug'] ) ); ?>"
		lang="<?php echo esc_attr( $locale ); ?>"
	>
		<span class="visually-hidden">
			<?php esc_html_e( 'Przełącz na język', 'newinlife-child' ); ?>
		</span>
		<?php echo esc_html( $slug ); ?>
	</a>
</nav>
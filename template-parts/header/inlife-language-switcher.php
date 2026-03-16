<?php
defined( 'ABSPATH' ) || exit;

$languages = inlife_get_languages();

if ( empty( $languages ) ) {
	return;
}
?>

<nav class="language-switcher" aria-label="<?php esc_attr_e( 'Wybór języka', 'understrap-child' ); ?>">
	<ul class="language-switcher__list list-unstyled d-flex align-items-center gap-2 mb-0">
		<?php foreach ( $languages as $lang ) : ?>
			<?php
			$is_current = ! empty( $lang['current_lang'] );
			$slug       = ! empty( $lang['slug'] ) ? strtoupper( $lang['slug'] ) : '';
			$url        = ! empty( $lang['url'] ) ? $lang['url'] : '#';
			$locale     = ! empty( $lang['locale'] ) ? $lang['locale'] : '';
			?>
			<li class="language-switcher__item">
				<a
					class="language-switcher__link<?php echo $is_current ? ' is-active' : ''; ?>"
					href="<?php echo esc_url( $url ); ?>"
					hreflang="<?php echo esc_attr( strtolower( $lang['slug'] ) ); ?>"
					lang="<?php echo esc_attr( $locale ); ?>"
					<?php echo $is_current ? 'aria-current="page"' : ''; ?>
				>
					<?php echo esc_html( $slug ); ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</nav>
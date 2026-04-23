<?php
/**
 * Career opportunities quick nav
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;
?>

<nav class="career-opportunities-quick-nav" aria-label="<?php echo esc_attr( inlife_t( 'Skróty do sekcji ofert i konkursów' ) ); ?>">
	<div class="career-opportunities-quick-nav__inner">
		<a class="career-opportunities-quick-nav__link" href="#aktualne-oferty">
			<?php echo esc_html( inlife_t( 'Aktualne oferty' ) ); ?>
		</a>
		<a class="career-opportunities-quick-nav__link" href="#wyniki-konkursow">
			<?php echo esc_html( inlife_t( 'Wyniki' ) ); ?>
		</a>
		<a class="career-opportunities-quick-nav__link" href="#ogloszenia-archiwalne">
			<?php echo esc_html( inlife_t( 'Archiwum' ) ); ?>
		</a>
		<a class="career-opportunities-quick-nav__link" href="#mobilnosc">
			<?php echo esc_html( inlife_t( 'Mobilność' ) ); ?>
		</a>
	</div>
</nav>
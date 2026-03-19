<?php
defined( 'ABSPATH' ) || exit;

add_action( 'init', 'inlife_register_footer_strings_for_polylang' );

function inlife_register_footer_strings_for_polylang() {
	if ( ! function_exists( 'pll_register_string' ) ) {
		return;
	}

	pll_register_string( 'footer_address_line_1', 'ul. Trylińskiego 18', 'Footer' );
	pll_register_string( 'footer_address_line_2', '10-683 Olsztyn, Polska', 'Footer' );
	pll_register_string(
		'footer_description',
		'InLife rozwija wiedzę i tworzy innowacje w obszarach żywności, zdrowia i rozrodu dla dobra ludzi, zwierząt i środowiska.',
		'Footer'
	);
}
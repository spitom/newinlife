<?php
defined( 'ABSPATH' ) || exit;

add_action( 'init', 'inlife_register_footer_strings_for_polylang' );

function inlife_register_footer_strings_for_polylang() {
	if ( ! function_exists( 'pll_register_string' ) ) {
		return;
	}

	$group = 'Footer';

	// Adres
	pll_register_string( 'footer_address_line_1', 'ul. Trylińskiego 18', $group );
	pll_register_string( 'footer_address_line_2', '10-683 Olsztyn, Polska', $group );

	// Opis
	pll_register_string(
		'footer_description',
		'InLife rozwija wiedzę i tworzy innowacje w obszarach żywności, zdrowia i rozrodu dla dobra ludzi, zwierząt i środowiska.',
		$group
	);

	// Nagłówki sekcji
	pll_register_string( 'footer_heading_contact', 'Kontakt', $group );
	pll_register_string( 'footer_heading_employee', 'Strefa pracownika', $group );
	pll_register_string( 'footer_heading_information', 'Informacje', $group );

	// Opcjonalne
	pll_register_string( 'footer_contact_email', 'E-mail', $group );
	pll_register_string( 'footer_contact_phone', 'Telefon', $group );
	pll_register_string( 'footer_copyright', '© InLife – Polska Akademia Nauk', $group );
}

if (!function_exists('inlife_register_polylang_strings')) {
	function inlife_register_polylang_strings() {
		if (!function_exists('pll_register_string')) {
			return;
		}

		$group = 'InLife Career';

		// Główna nawigacja / subnav
		pll_register_string('career_nav_career', 'Kariera', $group);
		pll_register_string('career_nav_offers', 'Oferty i konkursy', $group);

		// Okruszki
		pll_register_string('career_breadcrumbs_home', 'Strona główna', $group);

		// Single / nagłówki / meta
		pll_register_string('career_back_to_offers', 'Wróć do ofert', $group);
		pll_register_string('career_deadline', 'Termin składania', $group);
		pll_register_string('career_announcements', 'Komunikaty', $group);

		// CTA
		pll_register_string('career_cta_view_all', 'Zobacz wszystkie', $group);

		// Empty states
		pll_register_string('career_empty_no_current', 'Brak aktualnych ogłoszeń.', $group);
		pll_register_string('career_empty_no_results', 'Brak opublikowanych wyników.', $group);
		pll_register_string('career_empty_no_archive', 'Brak wpisów archiwalnych.', $group);
		pll_register_string('career_empty_no_items', 'Brak wpisów spełniających kryteria.', $group);

		// Sekcje / leady
		pll_register_string('career_section_recruitment', 'Rekrutacja', $group);
		pll_register_string('career_section_scientific_lead', 'Aktualne konkursy związane z pracą naukową, projektami badawczymi i rozwojem zespołów.', $group);
		pll_register_string('career_section_jobs_lead', 'Aktualne ogłoszenia o pracę i naborach prowadzonych przez Instytut.', $group);
		pll_register_string('career_section_results_lead', 'Rozstrzygnięcia postępowań, wyniki konkursów oraz informacje o zakończonych naborach.', $group);
		pll_register_string('career_section_archive_lead', 'Wcześniejsze ogłoszenia i komunikaty zachowane do celów informacyjnych.', $group);

		// Taxonomy / archive / headings
		pll_register_string('career_taxonomy_announcements', 'Komunikaty', $group);
		pll_register_string('career_archive_title', 'Oferty, konkursy i informacje', $group);
		pll_register_string('career_archive_lead', 'Centralne archiwum wpisów związanych z karierą: konkursów na stanowiska naukowe, ogłoszeń o pracę, wyników konkursów oraz wpisów archiwalnych.', $group);

		// Aside / informacje
		pll_register_string('career_info_basic', 'Informacje podstawowe', $group);
		pll_register_string('career_info_unit', 'Jednostka', $group);
		pll_register_string('career_info_project', 'Projekt', $group);
		pll_register_string('career_info_employment_type', 'Forma współpracy', $group);
		pll_register_string('career_info_location', 'Miejsce', $group);
		pll_register_string('career_info_contact', 'Kontakt', $group);
		pll_register_string('career_info_attachments', 'Załączniki', $group);
		pll_register_string('career_info_apply', 'Przejdź do aplikacji', $group);

		// RODO / formalności
		pll_register_string('career_formal_title', 'Informacje formalne', $group);
		pll_register_string('career_formal_default', 'Treść klauzuli RODO i zgody rekrutacyjnej będzie renderowana automatycznie na podstawie wybranego wariantu.', $group);

		// Archive card CTA
		pll_register_string('career_card_open', 'Przejdź do wpisu', $group);

		// Dodatkowe użyteczne
		pll_register_string('career_listing_count', 'Liczba wpisów', $group);
		pll_register_string('career_type_label', 'Typ komunikatu', $group);
	}
	add_action('init', 'inlife_register_polylang_strings');
}
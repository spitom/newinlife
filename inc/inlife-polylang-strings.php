<?php
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'inlife_register_polylang_strings' ) ) {
	/**
	 * Register theme strings for Polylang.
	 *
	 * @return void
	 */
	function inlife_register_polylang_strings() {
		if ( ! function_exists( 'pll_register_string' ) ) {
			return;
		}

		/*
		 * ------------------------------------------------------------
		 * Footer
		 * ------------------------------------------------------------
		 */
		$group = 'Footer';

		// Adres.
		pll_register_string( 'footer_address_line_1', 'ul. Trylińskiego 18', $group );
		pll_register_string( 'footer_address_line_2', '10-683 Olsztyn, Polska', $group );

		// Opis.
		pll_register_string(
			'footer_description',
			'InLife rozwija wiedzę i tworzy innowacje w obszarach żywności, zdrowia i rozrodu dla dobra ludzi, zwierząt i środowiska.',
			$group
		);

		// Nagłówki sekcji.
		pll_register_string( 'footer_heading_contact', 'Kontakt', $group );
		pll_register_string( 'footer_heading_employee', 'Strefa pracownika', $group );
		pll_register_string( 'footer_heading_information', 'Informacje', $group );

		// Dodatkowe.
		pll_register_string( 'footer_contact_email', 'E-mail', $group );
		pll_register_string( 'footer_contact_phone', 'Telefon', $group );
		pll_register_string( 'footer_copyright', '© InLife – Polska Akademia Nauk', $group );

		/*
		 * ------------------------------------------------------------
		 * InLife Career
		 * ------------------------------------------------------------
		 */
		$group = 'InLife Career';

		// Główna nawigacja / subnav.
		pll_register_string( 'career_nav_career', 'Kariera', $group );
		pll_register_string( 'career_nav_offers', 'Oferty i konkursy', $group );

		// Okruszki.
		pll_register_string( 'career_breadcrumbs_home', 'Strona główna', $group );

		// Single / nagłówki / meta.
		pll_register_string( 'career_back_to_offers', 'Wróć do ofert', $group );
		pll_register_string( 'career_deadline', 'Termin składania', $group );
		pll_register_string( 'career_announcements', 'Komunikaty', $group );

		// CTA.
		pll_register_string( 'career_cta_view_all', 'Zobacz wszystkie', $group );

		// Empty states.
		pll_register_string( 'career_empty_no_current', 'Brak aktualnych ogłoszeń.', $group );
		pll_register_string( 'career_empty_no_results', 'Brak opublikowanych wyników.', $group );
		pll_register_string( 'career_empty_no_archive', 'Brak wpisów archiwalnych.', $group );
		pll_register_string( 'career_empty_no_items', 'Brak wpisów spełniających kryteria.', $group );

		// Sekcje / leady.
		pll_register_string( 'career_section_recruitment', 'Rekrutacja', $group );
		pll_register_string(
			'career_section_scientific_lead',
			'Aktualne konkursy związane z pracą naukową, projektami badawczymi i rozwojem zespołów.',
			$group
		);
		pll_register_string(
			'career_section_jobs_lead',
			'Aktualne ogłoszenia o pracę i naborach prowadzonych przez Instytut.',
			$group
		);
		pll_register_string(
			'career_section_results_lead',
			'Rozstrzygnięcia postępowań, wyniki konkursów oraz informacje o zakończonych naborach.',
			$group
		);
		pll_register_string(
			'career_section_archive_lead',
			'Wcześniejsze ogłoszenia i komunikaty zachowane do celów informacyjnych.',
			$group
		);

		// Taxonomy / archive / headings.
		pll_register_string( 'career_taxonomy_announcements', 'Komunikaty', $group );
		pll_register_string( 'career_archive_title', 'Oferty, konkursy i informacje', $group );
		pll_register_string(
			'career_archive_lead',
			'Centralne archiwum wpisów związanych z karierą: konkursów na stanowiska naukowe, ogłoszeń o pracę, wyników konkursów oraz wpisów archiwalnych.',
			$group
		);

		// Aside / informacje.
		pll_register_string( 'career_info_basic', 'Informacje podstawowe', $group );
		pll_register_string( 'career_info_unit', 'Jednostka', $group );
		pll_register_string( 'career_info_project', 'Projekt', $group );
		pll_register_string( 'career_info_employment_type', 'Forma współpracy', $group );
		pll_register_string( 'career_info_location', 'Miejsce', $group );
		pll_register_string( 'career_info_contact', 'Kontakt', $group );
		pll_register_string( 'career_info_attachments', 'Załączniki', $group );
		pll_register_string( 'career_info_apply', 'Przejdź do aplikacji', $group );

		// RODO / formalności.
		pll_register_string( 'career_formal_title', 'Informacje formalne', $group );
		pll_register_string(
			'career_formal_default',
			'Treść klauzuli RODO i zgody rekrutacyjnej będzie renderowana automatycznie na podstawie wybranego wariantu.',
			$group
		);

		// Archive card CTA.
		pll_register_string( 'career_card_open', 'Przejdź do wpisu', $group );

		// Dodatkowe.
		pll_register_string( 'career_listing_count', 'Liczba wpisów', $group );
		pll_register_string( 'career_type_label', 'Typ komunikatu', $group );

		/*
		 * ------------------------------------------------------------
		 * InLife Teams
		 * ------------------------------------------------------------
		 */
		$group = 'InLife Teams';

		// Archive.
		pll_register_string( 'teams_archive_kicker', 'Badania', $group );
		pll_register_string( 'teams_archive_title', 'Zespoły badawcze', $group );
		pll_register_string(
			'teams_archive_lead',
			'Poznaj zespoły badawcze realizujące projekty w obszarach żywności, zdrowia oraz nauk o zwierzętach.',
			$group
		);
		pll_register_string( 'teams_archive_all', 'Wszystkie', $group );
		pll_register_string( 'teams_archive_view_team', 'Zobacz zespół', $group );
		pll_register_string( 'teams_archive_placeholder_label', 'Zespół', $group );
		pll_register_string( 'teams_archive_placeholder_team', 'Zespół badawczy', $group );

		// Single - hero / overview.
		pll_register_string( 'teams_single_kicker', 'Badania', $group );
		pll_register_string( 'teams_single_overview_title', 'Opis działalności', $group );
		pll_register_string( 'teams_single_profile_title', 'Profil jednostki', $group );
		pll_register_string(
			'teams_single_profile_text',
			'Szczegółowe informacje o zakresie działalności zespołu zostaną uzupełnione w kolejnym etapie wdrożenia.',
			$group
		);
		pll_register_string( 'teams_single_research_areas_title', 'Obszary badawcze', $group );
		pll_register_string(
			'teams_single_research_areas_text',
			'Ta sekcja będzie rozwijana wraz z docelowymi polami i treściami redakcyjnymi.',
			$group
		);

		// Single - leader / people.
		pll_register_string( 'teams_single_leader_title', 'Kierownik zespołu', $group );
		pll_register_string( 'teams_single_leader_fallback_role', 'Lider zespołu', $group );
		pll_register_string(
			'teams_single_leader_fallback_bio',
			'Opis kierownika zespołu zostanie uzupełniony po wdrożeniu danych osobowych.',
			$group
		);
		pll_register_string(
			'teams_single_leader_empty',
			'Kierownik zespołu nie został jeszcze przypisany.',
			$group
		);
		pll_register_string( 'teams_single_members_title', 'Skład zespołu', $group );
		pll_register_string(
			'teams_single_members_empty',
			'Skład zespołu nie został jeszcze uzupełniony.',
			$group
		);
		pll_register_string( 'teams_single_view_profile', 'Zobacz profil', $group );

		// Single - sections nav.
		pll_register_string( 'teams_single_sections_kicker', 'Dorobek i aktywność zespołu', $group );
		pll_register_string( 'teams_single_sections_title', 'Szczegóły działalności', $group );
		pll_register_string( 'teams_single_sections_aria', 'Nawigacja sekcji zespołu', $group );
		pll_register_string( 'teams_single_tab_research', 'Badania', $group );
		pll_register_string( 'teams_single_tab_projects', 'Aktualne projekty', $group );
		pll_register_string( 'teams_single_tab_publications', 'Publikacje', $group );
		pll_register_string( 'teams_single_tab_news', 'Aktualności', $group );

		// Single - research section.
		pll_register_string( 'teams_single_section_research_1', 'Obszar badawczy 1', $group );
		pll_register_string( 'teams_single_section_research_2', 'Obszar badawczy 2', $group );
		pll_register_string( 'teams_single_section_research_3', 'Obszar badawczy 3', $group );
		pll_register_string(
			'teams_single_section_research_text_1',
			'Miejsce na opis głównych linii badawczych zespołu.',
			$group
		);
		pll_register_string(
			'teams_single_section_research_text_2',
			'Sekcja przygotowana pod docelowe treści redakcyjne lub relacje.',
			$group
		);
		pll_register_string(
			'teams_single_section_research_text_3',
			'Układ gotowy do późniejszego rozwinięcia bez przebudowy całego widoku.',
			$group
		);

		// Single - projects section.
		pll_register_string(
			'teams_single_projects_lead',
			'Wybrane projekty i granty realizowane przez zespół.',
			$group
		);
		pll_register_string( 'teams_single_projects_cta', 'Zobacz wszystkie projekty zespołu', $group );

		// Single - publications section.
		pll_register_string(
			'teams_single_publication_placeholder_1',
			'Miejsce na publikację przypisaną do zespołu.',
			$group
		);
		pll_register_string(
			'teams_single_publication_placeholder_2',
			'Układ sekcji przygotowany pod grupowanie po latach.',
			$group
		);
		pll_register_string(
			'teams_single_publication_placeholder_3',
			'Docelowo lista będzie generowana automatycznie.',
			$group
		);
		pll_register_string(
			'teams_single_publication_placeholder_4',
			'Na tym etapie jest to makieta akceptacyjna zgodna z przyszłym wdrożeniem.',
			$group
		);

		// Single - news section.
		pll_register_string( 'teams_single_news_placeholder_1', 'Tytuł aktualności', $group );
		pll_register_string(
			'teams_single_news_text_1',
			'Sekcja przygotowana pod przyszłe przypisywanie aktualności tagiem lub relacją.',
			$group
		);
		pll_register_string(
			'teams_single_news_text_2',
			'Docelowo mogą tu trafiać wpisy zespołowe powiązane z tematyką jednostki.',
			$group
		);
		pll_register_string(
			'teams_single_news_text_3',
			'Układ wizualny już teraz jest gotowy do późniejszego podpięcia danych.',
			$group
		);

				/*
		 * ------------------------------------------------------------
		 * InLife Laboratories
		 * ------------------------------------------------------------
		 */
		$group = 'InLife Laboratories';

		// Archive.
		pll_register_string( 'labs_archive_kicker', 'Badania', $group );
		pll_register_string( 'labs_archive_title', 'Laboratoria', $group );
		pll_register_string(
			'labs_archive_lead',
			'Poznaj laboratoria wspierające działalność badawczą instytutu, oferujące specjalistyczne metody, analizy oraz zaplecze aparaturowe.',
			$group
		);
		pll_register_string( 'labs_archive_placeholder_label', 'Laboratorium', $group );
		pll_register_string( 'labs_archive_view_lab', 'Zobacz laboratorium', $group );

		// Single.
		pll_register_string( 'labs_single_kicker', 'Badania', $group );
		pll_register_string( 'labs_single_placeholder_label', 'Laboratorium', $group );

		pll_register_string( 'labs_single_profile_title', 'Profil jednostki', $group );
		pll_register_string( 'labs_single_scope_title', 'Zakres działalności', $group );
		pll_register_string(
			'labs_single_scope_text',
			'Informacje zostaną uzupełnione na kolejnym etapie wdrożenia.',
			$group
		);
		pll_register_string( 'labs_single_cooperation_title', 'Współpraca', $group );
		pll_register_string(
			'labs_single_cooperation_text',
			'Dane dotyczące współpracy i zastosowań zostaną rozwinięte wraz z modułem biznesowym.',
			$group
		);

		pll_register_string( 'labs_single_people_title', 'Skład osobowy', $group );
		pll_register_string( 'labs_single_manager_badge', 'Kierownik laboratorium', $group );
		pll_register_string(
			'labs_single_people_empty',
			'Skład osobowy nie został jeszcze uzupełniony.',
			$group
		);

		pll_register_string( 'labs_single_methods_title', 'Oferowane metody i analizy', $group );
		pll_register_string( 'labs_single_equipment_title', 'Wyposażenie laboratorium', $group );

		pll_register_string( 'labs_single_method_placeholder_title', 'Metoda analityczna', $group );
		pll_register_string(
			'labs_single_method_placeholder_text',
			'Opis metody, analizy lub zakresu usług laboratoryjnych.',
			$group
		);

		pll_register_string( 'labs_single_equipment_item_1', 'Spektrometr masowy', $group );
		pll_register_string( 'labs_single_equipment_item_2', 'Chromatograf cieczowy', $group );
		pll_register_string( 'labs_single_equipment_item_3', 'System PCR', $group );
		pll_register_string( 'labs_single_equipment_item_4', 'Mikroskop konfokalny', $group );

		pll_register_string( 'labs_single_view_profile', 'Zobacz profil', $group );
	}

	add_action( 'init', 'inlife_register_polylang_strings' );
}
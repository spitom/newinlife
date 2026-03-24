<?php
/**
 * ACF fields for People CPT
 *
 * @package newinlife
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'inlife_register_people_acf_fields' ) ) {
	function inlife_register_people_acf_fields() {

		if ( ! function_exists( 'acf_add_local_field_group' ) ) {
			return;
		}

		acf_add_local_field_group(
			[
				'key'                   => 'group_inlife_people_profile',
				'title'                 => __( 'Profil osoby', 'newinlife' ),
				'fields'                => [

					[
						'key'       => 'field_inlife_people_tab_basic',
						'label'     => __( 'Podstawowe informacje', 'newinlife' ),
						'name'      => '',
						'type'      => 'tab',
						'placement' => 'top',
						'endpoint'  => 0,
					],

					[
						'key'           => 'field_inlife_person_position',
						'label'         => __( 'Stanowisko', 'newinlife' ),
						'name'          => 'person_position',
						'type'          => 'text',
						'instructions'  => __( 'Np. Profesor instytutu, Adiunkt, Specjalista, Asystent administracyjny.', 'newinlife' ),
						'required'      => 0,
						'wrapper'       => [
							'width' => '50',
						],
						'default_value' => '',
						'maxlength'     => 160,
					],

					[
						'key'           => 'field_inlife_person_show_in_directory',
						'label'         => __( 'Pokazuj w katalogu', 'newinlife' ),
						'name'          => 'person_show_in_directory',
						'type'          => 'true_false',
						'instructions'  => __( 'Włącz, jeśli osoba ma być widoczna na archiwum oraz w publicznych listingach kadry.', 'newinlife' ),
						'required'      => 0,
						'wrapper'       => [
							'width' => '50',
						],
						'message'       => __( 'Tak, pokazuj tę osobę w katalogu', 'newinlife' ),
						'default_value' => 1,
						'ui'            => 1,
						'ui_on_text'    => __( 'Tak', 'newinlife' ),
						'ui_off_text'   => __( 'Nie', 'newinlife' ),
					],

					[
						'key'           => 'field_inlife_person_email',
						'label'         => __( 'E-mail', 'newinlife' ),
						'name'          => 'person_email',
						'type'          => 'email',
						'instructions'  => '',
						'required'      => 0,
						'wrapper'       => [
							'width' => '50',
						],
						'default_value' => '',
						'placeholder'   => 'name@example.com',
					],

					[
						'key'           => 'field_inlife_person_phone',
						'label'         => __( 'Telefon', 'newinlife' ),
						'name'          => 'person_phone',
						'type'          => 'text',
						'instructions'  => __( 'Np. +48 89 523 46 00 lub numer wewnętrzny.', 'newinlife' ),
						'required'      => 0,
						'wrapper'       => [
							'width' => '25',
						],
						'default_value' => '',
						'maxlength'     => 64,
					],

					[
						'key'           => 'field_inlife_person_room',
						'label'         => __( 'Pokój / lokalizacja', 'newinlife' ),
						'name'          => 'person_room',
						'type'          => 'text',
						'instructions'  => __( 'Np. Pokój 214, Budynek B, Sekretariat.', 'newinlife' ),
						'required'      => 0,
						'wrapper'       => [
							'width' => '25',
						],
						'default_value' => '',
						'maxlength'     => 120,
					],

					[
						'key'           => 'field_inlife_person_short_bio',
						'label'         => __( 'Krótki opis', 'newinlife' ),
						'name'          => 'person_short_bio',
						'type'          => 'textarea',
						'instructions'  => __( 'Krótki lead widoczny na profilu osoby. Najlepiej 1–3 zdania.', 'newinlife' ),
						'required'      => 0,
						'wrapper'       => [
							'width' => '100',
						],
						'default_value' => '',
						'maxlength'     => 450,
						'rows'          => 4,
						'new_lines'     => 'br',
					],

					[
						'key'           => 'field_inlife_person_long_bio',
						'label'         => __( 'Opis rozszerzony', 'newinlife' ),
						'name'          => 'person_long_bio',
						'type'          => 'wysiwyg',
						'instructions'  => __( 'Główna treść profilu osoby. Można zostawić puste i użyć standardowej treści wpisu, ale rekomendowane jest korzystanie z tego pola dla spójności modułu.', 'newinlife' ),
						'required'      => 0,
						'wrapper'       => [
							'width' => '100',
						],
						'default_value' => '',
						'tabs'          => 'all',
						'toolbar'       => 'basic',
						'media_upload'  => 0,
						'delay'         => 0,
					],

					[
						'key'       => 'field_inlife_people_tab_scientific',
						'label'     => __( 'Profil naukowy', 'newinlife' ),
						'name'      => '',
						'type'      => 'tab',
						'placement' => 'top',
						'endpoint'  => 0,
					],

					[
						'key'           => 'field_inlife_person_research_interests',
						'label'         => __( 'Zainteresowania badawcze', 'newinlife' ),
						'name'          => 'person_research_interests',
						'type'          => 'textarea',
						'instructions'  => __( 'Pole przeznaczone głównie dla pracowników naukowych.', 'newinlife' ),
						'required'      => 0,
						'wrapper'       => [
							'width' => '100',
						],
						'default_value' => '',
						'rows'          => 5,
						'new_lines'     => 'br',
					],

					[
						'key'           => 'field_inlife_person_specializations',
						'label'         => __( 'Specjalizacje / słowa kluczowe', 'newinlife' ),
						'name'          => 'person_specializations',
						'type'          => 'textarea',
						'instructions'  => __( 'Np. biologia rozrodu, nutrigenomika, mikrobiologia żywności.', 'newinlife' ),
						'required'      => 0,
						'wrapper'       => [
							'width' => '100',
						],
						'default_value' => '',
						'rows'          => 4,
						'new_lines'     => 'br',
					],

					[
						'key'           => 'field_inlife_person_orcid',
						'label'         => __( 'ORCID', 'newinlife' ),
						'name'          => 'person_orcid',
						'type'          => 'url',
						'instructions'  => __( 'Pełny adres URL do profilu ORCID.', 'newinlife' ),
						'required'      => 0,
						'wrapper'       => [
							'width' => '50',
						],
						'default_value' => '',
						'placeholder'   => 'https://orcid.org/0000-0000-0000-0000',
					],

					[
						'key'           => 'field_inlife_person_google_scholar',
						'label'         => __( 'Google Scholar', 'newinlife' ),
						'name'          => 'person_google_scholar',
						'type'          => 'url',
						'instructions'  => __( 'Pełny adres URL do profilu Google Scholar.', 'newinlife' ),
						'required'      => 0,
						'wrapper'       => [
							'width' => '50',
						],
						'default_value' => '',
					],

					[
						'key'           => 'field_inlife_person_researchgate',
						'label'         => __( 'ResearchGate', 'newinlife' ),
						'name'          => 'person_researchgate',
						'type'          => 'url',
						'instructions'  => __( 'Pełny adres URL do profilu ResearchGate.', 'newinlife' ),
						'required'      => 0,
						'wrapper'       => [
							'width' => '50',
						],
						'default_value' => '',
					],

					[
						'key'           => 'field_inlife_person_linkedin',
						'label'         => __( 'LinkedIn', 'newinlife' ),
						'name'          => 'person_linkedin',
						'type'          => 'url',
						'instructions'  => __( 'Opcjonalnie — pełny adres URL do profilu LinkedIn.', 'newinlife' ),
						'required'      => 0,
						'wrapper'       => [
							'width' => '50',
						],
						'default_value' => '',
					],

					[
						'key'       => 'field_inlife_people_tab_relations',
						'label'     => __( 'Powiązania', 'newinlife' ),
						'name'      => '',
						'type'      => 'tab',
						'placement' => 'top',
						'endpoint'  => 0,
					],

					[
						'key'           => 'field_inlife_team_memberships',
						'label'         => __( 'Powiązane zespoły', 'newinlife' ),
						'name'          => 'team_memberships',
						'type'          => 'repeater',
						'instructions'  => __( 'Dodaj zespoły, z którymi powiązana jest dana osoba. W ramach konkretnego powiązania możesz oznaczyć kierownika zespołu.', 'newinlife' ),
						'required'      => 0,
						'wrapper'       => [
							'width' => '100',
						],
						'layout'        => 'row',
						'min'           => 0,
						'max'           => 0,
						'collapsed'     => 'field_inlife_team_membership_team',
						'button_label'  => __( 'Dodaj zespół', 'newinlife' ),
						'sub_fields'    => [
							[
								'key'           => 'field_inlife_team_membership_team',
								'label'         => __( 'Zespół', 'newinlife' ),
								'name'          => 'team',
								'type'          => 'post_object',
								'instructions'  => '',
								'required'      => 1,
								'wrapper'       => [
									'width' => '70',
								],
								'post_type'     => [ 'teams' ],
								'post_status'   => [ 'publish', 'draft', 'pending', 'private' ],
								'return_format' => 'id',
								'multiple'      => 0,
								'allow_null'    => 0,
								'ui'            => 1,
							],
							[
								'key'           => 'field_inlife_team_membership_is_team_leader',
								'label'         => __( 'Kierownik zespołu', 'newinlife' ),
								'name'          => 'is_team_leader',
								'type'          => 'true_false',
								'instructions'  => __( 'Zaznacz tylko wtedy, gdy ta osoba jest kierownikiem wybranego wyżej zespołu.', 'newinlife' ),
								'required'      => 0,
								'wrapper'       => [
									'width' => '30',
								],
								'message'       => __( 'Ta osoba jest kierownikiem tego zespołu', 'newinlife' ),
								'default_value' => 0,
								'ui'            => 1,
								'ui_on_text'    => __( 'Tak', 'newinlife' ),
								'ui_off_text'   => __( 'Nie', 'newinlife' ),
							],
						],
					],

					[
						'key'           => 'field_inlife_laboratory_memberships',
						'label'         => __( 'Powiązane laboratoria', 'newinlife' ),
						'name'          => 'laboratory_memberships',
						'type'          => 'repeater',
						'instructions'  => __( 'Dodaj laboratoria, z którymi powiązana jest dana osoba.', 'newinlife' ),
						'required'      => 0,
						'wrapper'       => [
							'width' => '100',
						],
						'layout'        => 'row',
						'min'           => 0,
						'max'           => 0,
						'collapsed'     => 'field_inlife_laboratory_membership_laboratory',
						'button_label'  => __( 'Dodaj laboratorium', 'newinlife' ),
						'sub_fields'    => [
							[
								'key'           => 'field_inlife_laboratory_membership_laboratory',
								'label'         => __( 'Laboratorium', 'newinlife' ),
								'name'          => 'laboratory',
								'type'          => 'post_object',
								'instructions'  => '',
								'required'      => 1,
								'wrapper'       => [
									'width' => '100',
								],
								'post_type'     => [ 'laboratories' ],
								'post_status'   => [ 'publish', 'draft', 'pending', 'private' ],
								'return_format' => 'id',
								'multiple'      => 0,
								'allow_null'    => 0,
								'ui'            => 1,
							],
						],
					],

					[
						'key'       => 'field_inlife_people_tab_editorial',
						'label'     => __( 'Uwagi redakcyjne', 'newinlife' ),
						'name'      => '',
						'type'      => 'tab',
						'placement' => 'top',
						'endpoint'  => 0,
					],

					[
						'key'       => 'field_inlife_people_type_notice',
						'label'     => __( 'Wskazówka redakcyjna', 'newinlife' ),
						'name'      => 'people_type_notice',
						'type'      => 'message',
						'message'   => __(
							'Typ osoby ustawiany jest w taksonomii <strong>Typ osoby</strong>, a nie w polach ACF. Dla pracowników naukowych możesz uzupełnić dodatkowe pola w zakładce „Profil naukowy”.',
							'newinlife'
						),
						'new_lines' => 'wpautop',
						'esc_html'  => 0,
					],

				],
				'location'              => [
					[
						[
							'param'    => 'post_type',
							'operator' => '==',
							'value'    => 'people',
						],
					],
				],
				'menu_order'            => 0,
				'position'              => 'acf_after_title',
				'style'                 => 'seamless',
				'label_placement'       => 'top',
				'instruction_placement' => 'label',
				'active'                => true,
				'description'           => '',
				'show_in_rest'          => 0,
			]
		);
	}

	add_action( 'acf/init', 'inlife_register_people_acf_fields' );
}
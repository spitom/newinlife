<?php
defined( 'ABSPATH' ) || exit;

/**
 * Register Events CPT.
 */
add_action( 'init', 'inlife_register_events_cpt' );

function inlife_register_events_cpt(): void {

	$labels = [
		'name'                  => __( 'Wydarzenia', 'newinlife-child' ),
		'singular_name'         => __( 'Wydarzenie', 'newinlife-child' ),
		'menu_name'             => __( 'Wydarzenia', 'newinlife-child' ),
		'name_admin_bar'        => __( 'Wydarzenie', 'newinlife-child' ),
		'add_new'               => __( 'Dodaj nowe', 'newinlife-child' ),
		'add_new_item'          => __( 'Dodaj nowe wydarzenie', 'newinlife-child' ),
		'new_item'              => __( 'Nowe wydarzenie', 'newinlife-child' ),
		'edit_item'             => __( 'Edytuj wydarzenie', 'newinlife-child' ),
		'view_item'             => __( 'Zobacz wydarzenie', 'newinlife-child' ),
		'view_items'            => __( 'Zobacz wydarzenia', 'newinlife-child' ),
		'search_items'          => __( 'Szukaj wydarzeń', 'newinlife-child' ),
		'not_found'             => __( 'Nie znaleziono wydarzeń.', 'newinlife-child' ),
		'not_found_in_trash'    => __( 'Nie znaleziono wydarzeń w koszu.', 'newinlife-child' ),
		'all_items'             => __( 'Wszystkie wydarzenia', 'newinlife-child' ),
		'archives'              => __( 'Archiwum wydarzeń', 'newinlife-child' ),
		'attributes'            => __( 'Atrybuty wydarzenia', 'newinlife-child' ),
		'insert_into_item'      => __( 'Wstaw do wydarzenia', 'newinlife-child' ),
		'uploaded_to_this_item' => __( 'Przesłane do tego wydarzenia', 'newinlife-child' ),
		'filter_items_list'     => __( 'Filtruj listę wydarzeń', 'newinlife-child' ),
		'items_list_navigation' => __( 'Nawigacja listy wydarzeń', 'newinlife-child' ),
		'items_list'            => __( 'Lista wydarzeń', 'newinlife-child' ),
	];

	$args = [
		'labels'              => $labels,
		'public'              => true,
		'publicly_queryable'  => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'show_in_rest'        => true,
		'menu_position'       => 23,
		'menu_icon'           => 'dashicons-calendar-alt',
		'capability_type'     => 'post',
		'has_archive'         => 'wydarzenia',
		'rewrite'             => [
			'slug'       => 'wydarzenie',
			'with_front' => false,
			'feeds'      => false,
			'pages'      => false,
		],
		'query_var'           => true,
		'exclude_from_search' => false,
		'hierarchical'        => false,
		'supports'            => [
			'title',
			'editor',
			'thumbnail',
			'revisions',
		],
		'delete_with_user'    => false,
	];

	register_post_type( 'events', $args );
}

/**
 * Register Event Type taxonomy.
 */
add_action( 'init', 'inlife_register_event_type_taxonomy' );

function inlife_register_event_type_taxonomy(): void {

	$labels = [
		'name'              => __( 'Typy wydarzeń', 'newinlife-child' ),
		'singular_name'     => __( 'Typ wydarzenia', 'newinlife-child' ),
		'menu_name'         => __( 'Typy wydarzeń', 'newinlife-child' ),
		'all_items'         => __( 'Wszystkie typy wydarzeń', 'newinlife-child' ),
		'edit_item'         => __( 'Edytuj typ wydarzenia', 'newinlife-child' ),
		'view_item'         => __( 'Zobacz typ wydarzenia', 'newinlife-child' ),
		'update_item'       => __( 'Zaktualizuj typ wydarzenia', 'newinlife-child' ),
		'add_new_item'      => __( 'Dodaj nowy typ wydarzenia', 'newinlife-child' ),
		'new_item_name'     => __( 'Nazwa nowego typu wydarzenia', 'newinlife-child' ),
		'parent_item'       => __( 'Typ nadrzędny', 'newinlife-child' ),
		'parent_item_colon' => __( 'Typ nadrzędny:', 'newinlife-child' ),
		'search_items'      => __( 'Szukaj typów wydarzeń', 'newinlife-child' ),
		'not_found'         => __( 'Nie znaleziono typów wydarzeń.', 'newinlife-child' ),
		'no_terms'          => __( 'Brak typów wydarzeń', 'newinlife-child' ),
		'items_list'        => __( 'Lista typów wydarzeń', 'newinlife-child' ),
	];

	$args = [
		'labels'            => $labels,
		'public'            => true,
		'publicly_queryable'=> true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => true,
		'show_in_rest'      => true,
		'hierarchical'      => true,
		'rewrite'           => [
			'slug'         => 'wydarzenia',
			'with_front'   => false,
			'hierarchical' => false,
		],
	];

	register_taxonomy( 'event_type', [ 'events' ], $args );
}

add_action( 'init', 'inlife_register_event_type_rewrite_rules', 20 );

function inlife_register_event_type_rewrite_rules(): void {
	add_rewrite_rule(
		'^wydarzenia/([^/]+)/?$',
		'index.php?event_type=$matches[1]&lang=pl',
		'top'
	);

	add_rewrite_rule(
		'^en/events/([^/]+)/?$',
		'index.php?event_type=$matches[1]&lang=en',
		'top'
	);
}

/**
 * Admin filters for Events.
 */
add_action( 'restrict_manage_posts', 'inlife_events_admin_filters', 10, 2 );

function inlife_events_admin_filters( string $post_type, string $which ): void {
	if ( 'events' !== $post_type || 'top' !== $which ) {
		return;
	}

	/*
	 * Event type.
	 */
	$taxonomy = get_taxonomy( 'event_type' );

	if ( $taxonomy ) {
		$selected_type = isset( $_GET['event_type'] )
			? sanitize_text_field( wp_unslash( $_GET['event_type'] ) )
			: '';

		wp_dropdown_categories(
			[
				'show_option_all' => 'Wszystkie typy wydarzeń',
				'taxonomy'        => 'event_type',
				'name'            => 'event_type',
				'orderby'         => 'name',
				'value_field'     => 'slug',
				'selected'        => $selected_type,
				'hide_empty'      => false,
				'hierarchical'    => true,
			]
		);
	}

	/*
	 * Language.
	 */
	if ( function_exists( 'pll_languages_list' ) ) {
		$language_slugs = pll_languages_list(
			[
				'hide_empty' => 0,
				'fields'     => 'slug',
			]
		);

		$language_names = pll_languages_list(
			[
				'hide_empty' => 0,
				'fields'     => 'name',
			]
		);

		$selected_language = isset( $_GET['lang'] )
			? sanitize_key( wp_unslash( $_GET['lang'] ) )
			: '';
		?>

		<select name="lang">
			<option value="">
				<?php esc_html_e( 'Wszystkie języki', 'newinlife-child' ); ?>
			</option>

			<?php foreach ( $language_slugs as $index => $slug ) : ?>
				<option
					value="<?php echo esc_attr( $slug ); ?>"
					<?php selected( $selected_language, $slug ); ?>
				>
					<?php
					echo esc_html(
						$language_names[ $index ] ?? strtoupper( $slug )
					);
					?>
				</option>
			<?php endforeach; ?>
		</select>

		<?php
	}
}
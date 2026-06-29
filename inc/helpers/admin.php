<?php
defined( 'ABSPATH' ) || exit;

function inlife_admin_get_block_editor_disabled_post_types(): array {
	return [
		'people',
		'teams',
		'laboratories',
		'projects',
		'partners',
		'career_entry',
	];
}

function inlife_admin_get_controlled_page_templates(): array {
	return [
		'page-templates/template-about-overview.php',
		'page-templates/template-about-structure.php',
		'page-templates/template-about-history.php',
		'page-templates/template-research-overview.php',
		'page-templates/template-business-landing.php',
		'page-templates/template-career-landing.php',
		'page-templates/template-network.php',
		'page-templates/template-society-landing.php',
		'page-templates/template-contact.php',
		'page-templates/template-institute-publications.php',
	];
}

function inlife_admin_is_controlled_page( $post ): bool {
	$post = get_post( $post );

	if ( ! $post instanceof WP_Post || 'page' !== $post->post_type ) {
		return false;
	}

	$front_page_id = (int) get_option( 'page_on_front' );

	if ( $front_page_id && (int) $post->ID === $front_page_id ) {
		return true;
	}

	$template = get_page_template_slug( $post );

	return $template && in_array( $template, inlife_admin_get_controlled_page_templates(), true );
}

add_filter(
	'use_block_editor_for_post_type',
	function( $use_block_editor, $post_type ) {
		if ( in_array( $post_type, inlife_admin_get_block_editor_disabled_post_types(), true ) ) {
			return false;
		}

		return $use_block_editor;
	},
	10,
	2
);

add_filter(
	'use_block_editor_for_post',
	function( $use_block_editor, $post ) {
		if ( inlife_admin_is_controlled_page( $post ) ) {
			return false;
		}

		return $use_block_editor;
	},
	10,
	2
);

add_action(
	'admin_init',
	function() {
		if ( ! is_admin() ) {
			return;
		}

		$post_id = isset( $_GET['post'] ) ? absint( $_GET['post'] ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

		if ( ! $post_id ) {
			return;
		}

		if ( inlife_admin_is_controlled_page( $post_id ) ) {
			remove_post_type_support( 'page', 'editor' );
		}
	}
);

/**
 * Add a Polylang language filter to the People list in wp-admin.
 */
add_action(
	'restrict_manage_posts',
	function( $post_type, $which ) {
		if (
			'people' !== $post_type ||
			'top' !== $which ||
			! function_exists( 'pll_languages_list' )
		) {
			return;
		}

		$current_language = isset( $_GET['lang'] )
			? sanitize_key( wp_unslash( $_GET['lang'] ) )
			: '';

		$available_languages = pll_languages_list(
			array(
				'fields' => 'slug',
			)
		);

		if ( ! is_array( $available_languages ) || empty( $available_languages ) ) {
			return;
		}

		$language_options = array(
			'pl' => 'Polski',
			'en' => 'English',
		);
		?>
		<label class="screen-reader-text" for="filter-by-people-language">
			Język
		</label>

		<select name="lang" id="filter-by-people-language">
			<option value="">Wszystkie języki</option>

			<?php foreach ( $language_options as $language_slug => $language_label ) : ?>
				<?php if ( ! in_array( $language_slug, $available_languages, true ) ) : ?>
					<?php continue; ?>
				<?php endif; ?>

				<option
					value="<?php echo esc_attr( $language_slug ); ?>"
					<?php selected( $current_language, $language_slug ); ?>
				>
					<?php echo esc_html( $language_label ); ?>
				</option>
			<?php endforeach; ?>
		</select>
		<?php
	},
	10,
	2
);
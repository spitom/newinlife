<?php
/**
 * People archive query modifications
 *
 * @package newinlife
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'inlife_get_people_archive_candidate_ids_by_relation' ) ) {
	/**
	 * Returns candidate People IDs by ACF repeater subfield relation.
	 *
	 * @param string $repeater_field Repeater field name.
	 * @param string $subfield       Repeater subfield name.
	 * @param int    $related_id     Related object ID.
	 * @return int[]
	 */
	function inlife_get_people_archive_candidate_ids_by_relation( $repeater_field, $subfield, $related_id ) {
		global $wpdb;

		$related_id = (int) $related_id;

		if ( ! $repeater_field || ! $subfield || ! $related_id ) {
			return [];
		}

		$meta_key_like = $wpdb->esc_like( $repeater_field . '_' ) . '%_' . $wpdb->esc_like( $subfield );

		$sql = $wpdb->prepare(
			"
			SELECT DISTINCT pm.post_id
			FROM {$wpdb->postmeta} pm
			INNER JOIN {$wpdb->posts} p ON p.ID = pm.post_id
			WHERE p.post_type = %s
				AND p.post_status = %s
				AND pm.meta_key LIKE %s
				AND pm.meta_value = %s
			",
			'people',
			'publish',
			$meta_key_like,
			(string) $related_id
		);

		$results = $wpdb->get_col( $sql ); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared

		if ( empty( $results ) ) {
			return [];
		}

		return array_map( 'intval', $results );
	}
}

if ( ! function_exists( 'inlife_modify_people_archive_query' ) ) {
	function inlife_modify_people_archive_query( $query ) {
		global $wpdb;

		if ( is_admin() || ! $query->is_main_query() ) {
			return;
		}

		if ( ! is_post_type_archive( 'people' ) ) {
			return;
		}

		$query->set( 'post_type', 'people' );
		$query->set( 'posts_per_page', 24 );
		$query->set( 'orderby', 'title' );
		$query->set( 'order', 'ASC' );

		$meta_query = [
			'relation' => 'OR',
			[
				'key'     => 'person_show_in_directory',
				'value'   => '1',
				'compare' => '=',
			],
			[
				'key'     => 'person_show_in_directory',
				'compare' => 'NOT EXISTS',
			],
		];

		$tax_query = [];

		$current_type   = isset( $_GET['people_type'] ) ? sanitize_text_field( wp_unslash( $_GET['people_type'] ) ) : '';
		$current_team   = isset( $_GET['team'] ) ? (int) $_GET['team'] : 0;
		$current_lab    = isset( $_GET['lab'] ) ? (int) $_GET['lab'] : 0;
		$current_letter = isset( $_GET['letter'] ) ? strtoupper( sanitize_text_field( wp_unslash( $_GET['letter'] ) ) ) : '';

		if ( $current_letter && preg_match( '/^[A-Z]$/', $current_letter ) ) {
			$query->set( 'people_archive_letter', $current_letter );
		}
		
		if ( $current_type ) {
			$tax_query[] = [
				'taxonomy' => 'people_type',
				'field'    => 'slug',
				'terms'    => [ $current_type ],
			];
		}

		if ( ! empty( $tax_query ) ) {
			$query->set( 'tax_query', $tax_query );
		}

		if ( ! function_exists( 'get_field' ) ) {
			$query->set( 'meta_query', $meta_query );

			if ( $current_letter && preg_match( '/^[A-Z]$/', $current_letter ) ) {
				add_filter(
					'posts_where',
					static function ( $where ) use ( $wpdb, $current_letter ) {
						return $where . $wpdb->prepare(
							" AND {$wpdb->posts}.post_title LIKE %s",
							$wpdb->esc_like( $current_letter ) . '%'
						);
					}
				);
			}

			return;
		}

		$candidate_sets = [];

		if ( $current_team ) {
			$team_ids = inlife_get_people_archive_candidate_ids_by_relation(
				'team_memberships',
				'team',
				$current_team
			);

			$candidate_sets[] = $team_ids;
		}

		if ( $current_lab ) {
			$lab_ids = inlife_get_people_archive_candidate_ids_by_relation(
				'laboratory_memberships',
				'laboratory',
				$current_lab
			);

			$candidate_sets[] = $lab_ids;
		}

		if ( ! empty( $candidate_sets ) ) {
			$filtered_ids = array_shift( $candidate_sets );

			foreach ( $candidate_sets as $set_ids ) {
				$filtered_ids = array_intersect( $filtered_ids, $set_ids );
			}

			$filtered_ids = array_values( array_unique( array_map( 'intval', $filtered_ids ) ) );

			if ( empty( $filtered_ids ) ) {
				$filtered_ids = [ 0 ];
			}

			$query->set( 'post__in', $filtered_ids );
		}

		$query->set( 'meta_query', $meta_query );

		
	}
	add_action( 'pre_get_posts', 'inlife_modify_people_archive_query' );
}

if ( ! function_exists( 'inlife_filter_people_archive_by_letter' ) ) {
	function inlife_filter_people_archive_by_letter( $where, $query ) {
		global $wpdb;

		if ( is_admin() || ! $query->is_main_query() ) {
			return $where;
		}

		if ( ! $query->is_post_type_archive( 'people' ) ) {
			return $where;
		}

		$letter = $query->get( 'people_archive_letter' );

		if ( ! $letter || ! preg_match( '/^[A-Z]$/', $letter ) ) {
			return $where;
		}

		$where .= $wpdb->prepare(
			" AND {$wpdb->posts}.post_title LIKE %s",
			$wpdb->esc_like( $letter ) . '%'
		);

		return $where;
	}
}
add_filter( 'posts_where', 'inlife_filter_people_archive_by_letter', 10, 2 );


if ( ! function_exists( 'inlife_render_obfuscated_email_link' ) ) {
	/**
	 * Link e-mail oparty o data-*.
	 *
	 * W HTML nie zapisujemy pełnego adresu e-mail, tylko:
	 * - data-user
	 * - data-domain
	 * oraz tekst typu "user [at] domain".
	 *
	 * Po kliknięciu JS składa adres i otwiera mailto:.
	 *
	 * @param string $email       Pełny adres e-mail.
	 * @param string $class       Dodatkowe klasy dla linku.
	 * @param string $label_html  Opcjonalny HTML przed adresem / wewnątrz linku.
	 * @return string
	 */
	function inlife_render_obfuscated_email_link( $email, $class = '', $label_html = '' ) {
		$email = trim( (string) $email );

		if ( '' === $email || false === strpos( $email, '@' ) ) {
			return '';
		}

		$parts = explode( '@', $email, 2 );
		$user  = trim( $parts[0] );
		$domain = trim( $parts[1] );

		if ( '' === $user || '' === $domain ) {
			return '';
		}

		$classes = trim( 'js-obfuscated-email ' . $class );
		$visible = $user . ' [at] ' . $domain;

		ob_start();
		?>
		<a
			href="#"
			class="<?php echo esc_attr( $classes ); ?>"
			data-user="<?php echo esc_attr( $user ); ?>"
			data-domain="<?php echo esc_attr( $domain ); ?>"
			aria-label="<?php echo esc_attr( $email ); ?>"
		>
			<?php
			if ( '' !== $label_html ) {
				echo $label_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
			?>
			<span class="js-obfuscated-email__text"><?php echo esc_html( $visible ); ?></span>
		</a>
		<?php
		return trim( (string) ob_get_clean() );
	}
}
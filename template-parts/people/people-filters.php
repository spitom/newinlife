<?php
defined( 'ABSPATH' ) || exit;

/**
 * Current filters.
 * Bierzemy people_type najpierw z GET, a jeśli z jakiegoś powodu go tam nie ma,
 * próbujemy fallback do query var.
 */
$current_type = '';

if ( isset( $_GET['people_type'] ) && is_string( $_GET['people_type'] ) ) {
	$current_type = sanitize_title( wp_unslash( $_GET['people_type'] ) );
}

if ( '' === $current_type ) {
	$query_var_type = get_query_var( 'people_type' );
	if ( is_string( $query_var_type ) ) {
		$current_type = sanitize_title( $query_var_type );
	}
}

$current_team = isset( $_GET['team'] ) ? (int) $_GET['team'] : 0;
$current_lab  = isset( $_GET['lab'] ) ? (int) $_GET['lab'] : 0;
$current_s    = isset( $_GET['s'] ) && is_string( $_GET['s'] )
	? sanitize_text_field( wp_unslash( $_GET['s'] ) )
	: '';

$current_letter = isset( $_GET['letter'] ) && is_string( $_GET['letter'] )
	? strtoupper( sanitize_text_field( wp_unslash( $_GET['letter'] ) ) )
	: '';

$types = get_terms(
	[
		'taxonomy'   => 'people_type',
		'hide_empty' => false,
	]
);

if ( ! empty( $types ) && is_array( $types ) ) {
	$desired_order = [ 'scientific', 'staff' ];

	usort(
		$types,
		static function( $a, $b ) use ( $desired_order ) {
			$a_index = array_search( $a->slug, $desired_order, true );
			$b_index = array_search( $b->slug, $desired_order, true );

			$a_index = false === $a_index ? 999 : $a_index;
			$b_index = false === $b_index ? 999 : $b_index;

			return $a_index <=> $b_index;
		}
	);
}

$teams = get_posts(
	[
		'post_type'      => 'teams',
		'posts_per_page' => -1,
		'orderby'        => 'title',
		'order'          => 'ASC',
		'post_status'    => [ 'publish' ],
	]
);

$labs = get_posts(
	[
		'post_type'      => 'laboratories',
		'posts_per_page' => -1,
		'orderby'        => 'title',
		'order'          => 'ASC',
		'post_status'    => [ 'publish' ],
	]
);

$archive_url = get_post_type_archive_link( 'people' );

/**
 * Bazowe argumenty zachowywane przy klikaniu pillsów.
 * people_type dokładamy osobno dla konkretnego pillsa.
 */
$base_args = [
	'post_type' => 'people',
];

if ( '' !== $current_s ) {
	$base_args['s'] = $current_s;
}

if ( '' !== $current_letter ) {
	$base_args['letter'] = $current_letter;
}

if ( $current_team ) {
	$base_args['team'] = $current_team;
}

if ( $current_lab ) {
	$base_args['lab'] = $current_lab;
}
?>

<div class="people-filters-wrap">
	<?php if ( ! empty( $types ) && is_array( $types ) && ! is_wp_error( $types ) ) : ?>
		<div class="people-filters people-filters--pills" aria-label="<?php echo esc_attr__( 'Filtruj według typu osoby', 'newinlife' ); ?>">
			<a
				class="people-filters__pill<?php echo '' === $current_type ? ' is-active' : ''; ?>"
				<?php echo '' === $current_type ? 'aria-current="page"' : ''; ?>
				href="<?php echo esc_url( add_query_arg( $base_args, $archive_url ) ); ?>"
			>
				<?php esc_html_e( 'Wszyscy', 'newinlife' ); ?>
			</a>

			<?php foreach ( $types as $type ) : ?>
				<?php
				if ( ! $type || empty( $type->slug ) ) {
					continue;
				}

				$type_slug = sanitize_title( (string) $type->slug );
				$type_args = $base_args;
				$type_args['people_type'] = $type_slug;
				?>
				<a
					class="people-filters__pill<?php echo $current_type === $type_slug ? ' is-active' : ''; ?>"
					<?php echo $current_type === $type_slug ? 'aria-current="page"' : ''; ?>
					href="<?php echo esc_url( add_query_arg( $type_args, $archive_url ) ); ?>"
				>
					<?php echo esc_html( $type->name ); ?>
				</a>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<form class="people-filters-form" method="get" action="<?php echo esc_url( $archive_url ); ?>">
		<input type="hidden" name="post_type" value="people">

		<?php if ( '' !== $current_s ) : ?>
			<input type="hidden" name="s" value="<?php echo esc_attr( $current_s ); ?>">
		<?php endif; ?>

		<?php if ( '' !== $current_type ) : ?>
			<input type="hidden" name="people_type" value="<?php echo esc_attr( $current_type ); ?>">
		<?php endif; ?>

		<?php if ( '' !== $current_letter ) : ?>
			<input type="hidden" name="letter" value="<?php echo esc_attr( $current_letter ); ?>">
		<?php endif; ?>

		<div class="row g-3 align-items-end">
			<div class="col-lg-4 col-md-6">
				<label class="form-label people-filters-form__label" for="people-team-filter">
					<?php esc_html_e( 'Zespół', 'newinlife' ); ?>
				</label>
				<select id="people-team-filter" name="team" class="form-select">
					<option value=""><?php esc_html_e( 'Wszystkie zespoły', 'newinlife' ); ?></option>
					<?php foreach ( $teams as $team ) : ?>
						<option value="<?php echo esc_attr( $team->ID ); ?>" <?php selected( $current_team, $team->ID ); ?>>
							<?php echo esc_html( get_the_title( $team ) ); ?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>

			<div class="col-lg-4 col-md-6">
				<label class="form-label people-filters-form__label" for="people-lab-filter">
					<?php esc_html_e( 'Laboratorium', 'newinlife' ); ?>
				</label>
				<select id="people-lab-filter" name="lab" class="form-select">
					<option value=""><?php esc_html_e( 'Wszystkie laboratoria', 'newinlife' ); ?></option>
					<?php foreach ( $labs as $lab ) : ?>
						<option value="<?php echo esc_attr( $lab->ID ); ?>" <?php selected( $current_lab, $lab->ID ); ?>>
							<?php echo esc_html( get_the_title( $lab ) ); ?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>

			<div class="col-lg-4 col-md-12">
				<div class="people-filters-form__actions">
					<button type="submit" class="btn btn-primary">
						<?php esc_html_e( 'Filtruj', 'newinlife' ); ?>
					</button>

					<a class="btn btn-outline-primary" href="<?php echo esc_url( get_post_type_archive_link( 'people' ) ); ?>">
						<?php esc_html_e( 'Wyczyść', 'newinlife' ); ?>
					</a>
				</div>
			</div>
		</div>
	</form>
</div>
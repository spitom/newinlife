<?php
defined( 'ABSPATH' ) || exit;

$current_letter = isset( $_GET['letter'] ) ? strtoupper( sanitize_text_field( wp_unslash( $_GET['letter'] ) ) ) : '';
$current_type   = isset( $_GET['people_type'] ) ? sanitize_text_field( wp_unslash( $_GET['people_type'] ) ) : '';
$current_team   = isset( $_GET['team'] ) ? (int) $_GET['team'] : 0;
$current_lab    = isset( $_GET['lab'] ) ? (int) $_GET['lab'] : 0;
$current_s      = get_query_var( 's' );

$archive_url = get_post_type_archive_link( 'people' );
$letters     = range( 'A', 'Z' );

$base_args = [
	'post_type' => 'people',
];

if ( $current_s ) {
	$base_args['s'] = $current_s;
}

if ( $current_type ) {
	$base_args['people_type'] = $current_type;
}

if ( $current_team ) {
	$base_args['team'] = $current_team;
}

if ( $current_lab ) {
	$base_args['lab'] = $current_lab;
}
?>

<nav class="people-alpha-filter c-surface c-surface--compact" aria-label="<?php echo esc_attr__( 'Filtr alfabetyczny osób', 'newinlife' ); ?>">
	<div class="people-alpha-filter__inner c-pills">
		<?php $all_args = $base_args; ?>
		<a
			class="people-alpha-filter__link c-pill c-pill--compact<?php echo '' === $current_letter ? ' is-active' : ''; ?>"
			<?php echo '' === $current_letter ? 'aria-current="page"' : ''; ?>
			href="<?php echo esc_url( add_query_arg( $all_args, $archive_url ) ); ?>"
		>
			<?php esc_html_e( 'Wszystkie', 'newinlife' ); ?>
		</a>

		<?php foreach ( $letters as $letter ) : ?>
			<?php
			$letter_args           = $base_args;
			$letter_args['letter'] = $letter;
			?>
			<a
				class="people-alpha-filter__link c-pill c-pill--compact<?php echo $current_letter === $letter ? ' is-active' : ''; ?>"
				<?php echo $current_letter === $letter ? 'aria-current="page"' : ''; ?>
				href="<?php echo esc_url( add_query_arg( $letter_args, $archive_url ) ); ?>"
			>
				<?php echo esc_html( $letter ); ?>
			</a>
		<?php endforeach; ?>
	</div>
</nav>
<?php
defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

$teams_raw = function_exists( 'get_field' ) ? get_field( 'team_memberships', $post_id ) : [];
$labs_raw  = function_exists( 'get_field' ) ? get_field( 'laboratory_memberships', $post_id ) : [];

$teams = [];
$labs  = [];

if ( is_array( $teams_raw ) ) {
	foreach ( $teams_raw as $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}

		$team_id = isset( $row['team'] ) ? (int) $row['team'] : 0;
		if ( $team_id > 0 ) {
			$teams[] = $team_id;
		}
	}
}

if ( is_array( $labs_raw ) ) {
	foreach ( $labs_raw as $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}

		$lab_id = isset( $row['laboratory'] ) ? (int) $row['laboratory'] : 0;
		if ( $lab_id > 0 ) {
			$labs[] = $lab_id;
		}
	}
}

$teams = array_values( array_unique( $teams ) );
$labs  = array_values( array_unique( $labs ) );

if ( empty( $teams ) && empty( $labs ) ) {
	return;
}
?>

<div class="people-single-panel c-surface c-surface--panel">
	<h2 class="people-single-panel__title">
		<?php esc_html_e( 'Powiązania', 'newinlife' ); ?>
	</h2>

	<?php if ( ! empty( $teams ) ) : ?>
		<div class="people-single-relations-group">
			<!-- <h3 class="people-single-relations-group__title"><?php esc_html_e( 'Zespoły', 'newinlife' ); ?></h3> -->
			<div class="people-single-relations-group__links">
				<?php foreach ( $teams as $team_id ) : ?>
					<a href="<?php echo esc_url( get_permalink( $team_id ) ); ?>">
						<?php echo esc_html( get_the_title( $team_id ) ); ?>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endif; ?>

	<?php if ( ! empty( $labs ) ) : ?>
		<div class="people-single-relations-group">
			<h3 class="people-single-relations-group__title"><?php esc_html_e( 'Laboratoria', 'newinlife' ); ?></h3>
			<div class="people-single-relations-group__links">
				<?php foreach ( $labs as $lab_id ) : ?>
					<a href="<?php echo esc_url( get_permalink( $lab_id ) ); ?>">
						<?php echo esc_html( get_the_title( $lab_id ) ); ?>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endif; ?>
</div>
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

		if ( $team_id <= 0 ) {
			continue;
		}

		$teams[] = [
			'id'        => $team_id,
			'is_leader' => ! empty( $row['is_team_leader'] ),
		];
	}
}

if ( is_array( $labs_raw ) ) {

	foreach ( $labs_raw as $row ) {

		if ( ! is_array( $row ) ) {
			continue;
		}

		$lab_id = isset( $row['laboratory'] ) ? (int) $row['laboratory'] : 0;

		if ( $lab_id <= 0 ) {
			continue;
		}

		$labs[] = [
			'id'         => $lab_id,
			'is_manager' => ! empty( $row['is_laboratory_manager'] ),
		];
	}
}

if ( empty( $teams ) && empty( $labs ) ) {
	return;
}
?>

<section class="people-profile-aside-section people-profile-aside-section--relations">

	<h2 class="people-profile-aside-section__title">
		<?php echo esc_html( inlife_t( 'Powiązania' ) ); ?>
	</h2>

	<?php if ( ! empty( $teams ) ) : ?>

		<div class="people-profile-relations-group">

			<h3 class="people-profile-relations-group__title">
				<?php echo esc_html( inlife_t( 'Zespoły' ) ); ?>
			</h3>

			<div class="people-profile-relations-group__items">

				<?php foreach ( $teams as $team ) : ?>

					<a
						href="<?php echo esc_url( get_permalink( $team['id'] ) ); ?>"
						class="people-profile-relations-group__link"
					>

						<span class="people-profile-relations-group__name">
							<?php echo esc_html( get_the_title( $team['id'] ) ); ?>
						</span>

						<?php if ( $team['is_leader'] ) : ?>
							<span class="c-badge c-badge--role">
								<?php echo esc_html( inlife_t( 'Kierownik' ) ); ?>
							</span>
						<?php endif; ?>

					</a>

				<?php endforeach; ?>

			</div>

		</div>

	<?php endif; ?>

	<?php if ( ! empty( $labs ) ) : ?>

		<div class="people-profile-relations-group">

			<h3 class="people-profile-relations-group__title">
				<?php echo esc_html( inlife_t( 'Laboratoria' ) ); ?>
			</h3>

			<div class="people-profile-relations-group__items">

				<?php foreach ( $labs as $lab ) : ?>

					<a
						href="<?php echo esc_url( get_permalink( $lab['id'] ) ); ?>"
						class="people-profile-relations-group__link"
					>

						<span class="people-profile-relations-group__name">
							<?php echo esc_html( get_the_title( $lab['id'] ) ); ?>
						</span>

						<?php if ( $lab['is_manager'] ) : ?>
							<span class="c-badge c-badge--role">
								<?php echo esc_html( inlife_t( 'Kierownik' ) ); ?>
							</span>
						<?php endif; ?>

					</a>

				<?php endforeach; ?>

			</div>

		</div>

	<?php endif; ?>

</section>
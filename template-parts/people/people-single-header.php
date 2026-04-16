<?php
defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

$type_slug  = '';
$type_label = '';

$terms = get_the_terms( $post_id, 'people_type' );
if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
	$type_slug  = $terms[0]->slug;
	$type_label = $terms[0]->name;
}

$academic_title = function_exists( 'get_field' ) ? get_field( 'person_academic_title', $post_id ) : '';
$position       = function_exists( 'get_field' ) ? get_field( 'person_position', $post_id ) : '';

$email = function_exists( 'get_field' ) ? get_field( 'person_email', $post_id ) : '';
$phone = function_exists( 'get_field' ) ? get_field( 'person_phone', $post_id ) : '';
$room  = function_exists( 'get_field' ) ? get_field( 'person_room', $post_id ) : '';

$name = trim( get_the_title( $post_id ) );

$display_name = trim( $academic_title . ' ' . $name );
if ( '' === $display_name ) {
	$display_name = $name;
}

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

$has_photo = has_post_thumbnail( $post_id );
?>

<div class="people-single-hero<?php echo $has_photo ? ' people-single-hero--has-photo' : ' people-single-hero--no-photo'; ?>">
	<div class="people-single-hero__main">
		<?php if ( $has_photo ) : ?>
			<div class="people-single-hero__media">
				<?php
				echo get_the_post_thumbnail(
					$post_id,
					'large',
					[
						'class'   => 'people-single-hero__image',
						'loading' => 'eager',
					]
				);
				?>
			</div>
		<?php endif; ?>

		<div class="people-single-hero__content">
			<?php if ( $type_label ) : ?>
				<p class="people-single-hero__type section-kicker">
					<?php echo esc_html( $type_label ); ?>
				</p>
			<?php endif; ?>

			<h1 class="people-single-hero__title section-title">
				<?php echo esc_html( $display_name ); ?>
			</h1>

			<?php if ( $position ) : ?>
				<p class="people-single-hero__position section-lead">
					<?php echo esc_html( $position ); ?>
				</p>
			<?php endif; ?>

			<?php if ( ! empty( $teams ) || ! empty( $labs ) ) : ?>
				<div class="people-single-hero__relations">
					<?php foreach ( $teams as $team_id ) : ?>
						<a href="<?php echo esc_url( get_permalink( $team_id ) ); ?>" class="people-single-hero__relation-link">
							<?php echo esc_html( get_the_title( $team_id ) ); ?>
						</a>
					<?php endforeach; ?>

					<?php foreach ( $labs as $lab_id ) : ?>
						<a href="<?php echo esc_url( get_permalink( $lab_id ) ); ?>" class="people-single-hero__relation-link">
							<?php echo esc_html( get_the_title( $lab_id ) ); ?>
						</a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>

	<?php if ( $email || $phone || $room ) : ?>
		<aside class="people-single-hero__meta">
			<div class="people-single-hero__meta-inner">
				<?php if ( $email ) : ?>
					<div class="people-single-hero__meta-item">
						<span class="people-single-hero__meta-label"><?php esc_html_e( 'E-mail', 'newinlife' ); ?></span>
						<?php
						echo inlife_render_obfuscated_email_link(
							$email,
							'people-single-hero__email-link'
						); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						?>
					</div>
				<?php endif; ?>

				<?php if ( $phone ) : ?>
					<div class="people-single-hero__meta-item">
						<span class="people-single-hero__meta-label"><?php esc_html_e( 'Telefon', 'newinlife' ); ?></span>
						<a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $phone ) ); ?>">
							<?php echo esc_html( $phone ); ?>
						</a>
					</div>
				<?php endif; ?>

				<?php if ( $room ) : ?>
					<div class="people-single-hero__meta-item">
						<span class="people-single-hero__meta-label"><?php esc_html_e( 'Pokój', 'newinlife' ); ?></span>
						<span><?php echo esc_html( $room ); ?></span>
					</div>
				<?php endif; ?>
			</div>
		</aside>
	<?php endif; ?>
</div>
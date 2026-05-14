<?php
defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

$type_label = '';
$terms      = get_the_terms( $post_id, 'people_type' );

if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
	$type_label = $terms[0]->name;
}

$academic_title = function_exists( 'get_field' ) ? get_field( 'person_academic_title', $post_id ) : '';
$position       = function_exists( 'get_field' ) ? get_field( 'person_position', $post_id ) : '';
$short_bio      = function_exists( 'get_field' ) ? get_field( 'person_short_bio', $post_id ) : '';

$email = function_exists( 'get_field' ) ? get_field( 'person_email', $post_id ) : '';
$phone = function_exists( 'get_field' ) ? get_field( 'person_phone', $post_id ) : '';
$room  = function_exists( 'get_field' ) ? get_field( 'person_room', $post_id ) : '';

$name         = trim( get_the_title( $post_id ) );
$display_name = trim( $academic_title . ' ' . $name );

if ( '' === $display_name ) {
	$display_name = $name;
}

$teams_raw = function_exists( 'get_field' ) ? get_field( 'team_memberships', $post_id ) : [];
$labs_raw  = function_exists( 'get_field' ) ? get_field( 'laboratory_memberships', $post_id ) : [];

$relations = [];

if ( is_array( $teams_raw ) ) {
	foreach ( $teams_raw as $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}

		$team_id = isset( $row['team'] ) ? (int) $row['team'] : 0;

		if ( $team_id > 0 ) {
			$relations[] = [
				'label' => get_the_title( $team_id ),
				'url'   => get_permalink( $team_id ),
			];
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
			$relations[] = [
				'label' => get_the_title( $lab_id ),
				'url'   => get_permalink( $lab_id ),
			];
		}
	}
}

$has_photo = has_post_thumbnail( $post_id );
?>

<div class="people-profile-hero<?php echo $has_photo ? ' people-profile-hero--has-photo' : ' people-profile-hero--no-photo'; ?>">
	<div class="people-profile-hero__media">
		<?php if ( $has_photo ) : ?>
			<?php
			echo get_the_post_thumbnail(
				$post_id,
				'large',
				[
					'class'   => 'people-profile-hero__image',
					'loading' => 'eager',
				]
			);
			?>
		<?php endif; ?>
	</div>

	<div class="people-profile-hero__content">
		<!-- </?php if ( $type_label ) : ?>
			<p class="people-profile-hero__kicker section-kicker">
				</?php echo esc_html( $type_label ); ?>
			</p>
		</?php endif; ?> -->
		
		<?php if ( ! empty( $relations ) ) : ?>
			<div class="people-profile-hero__relations">
				<?php foreach ( $relations as $relation ) : ?>
					<a href="<?php echo esc_url( $relation['url'] ); ?>" class="people-profile-hero__ c-badge c-badge--outline">
						<?php echo esc_html( $relation['label'] ); ?>
					</a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<h1 class="people-profile-hero__title">
			<?php echo esc_html( $display_name ); ?>
		</h1>

		<?php if ( $position ) : ?>
			<p class="people-profile-hero__position">
				<?php echo esc_html( $position ); ?>
			</p>
		<?php endif; ?>

		<?php if ( $short_bio ) : ?>
			<div class="people-profile-hero__lead">
				<?php echo wp_kses_post( wpautop( $short_bio ) ); ?>
			</div>
		<?php endif; ?>
	</div>

	<?php if ( $email || $phone || $room ) : ?>
		<aside class="people-profile-hero__contact" aria-label="<?php echo esc_attr( inlife_t( 'Dane kontaktowe' ) ); ?>">
			<?php if ( $email ) : ?>
				<div class="people-profile-hero__contact-item">
					<span class="people-profile-hero__contact-icon" aria-hidden="true">
						<i class="bi bi-envelope"></i>
					</span>
					<div>
						<span class="people-profile-hero__contact-label">
							<?php echo esc_html( inlife_t( 'E-mail' ) ); ?>
						</span>
						<?php
						echo inlife_render_obfuscated_email_link(
							$email,
							'people-profile-hero__contact-link'
						); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						?>
					</div>
				</div>
			<?php endif; ?>

			<?php if ( $phone ) : ?>
				<div class="people-profile-hero__contact-item">
					<span class="people-profile-hero__contact-icon" aria-hidden="true">
						<i class="bi bi-telephone"></i>
					</span>
					<div>
						<span class="people-profile-hero__contact-label">
							<?php echo esc_html( inlife_t( 'Telefon' ) ); ?>
						</span>
						<a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $phone ) ); ?>" class="people-profile-hero__contact-link">
							<?php echo esc_html( $phone ); ?>
						</a>
					</div>
				</div>
			<?php endif; ?>

			<?php if ( $room ) : ?>
				<div class="people-profile-hero__contact-item">
					<span class="people-profile-hero__contact-icon" aria-hidden="true">
						<i class="bi bi-door-open"></i>
					</span>
					<div>
						<span class="people-profile-hero__contact-label">
							<?php echo esc_html( inlife_t( 'Pokój' ) ); ?>
						</span>
						<span class="people-profile-hero__contact-text"><?php echo esc_html( $room ); ?></span>
					</div>
				</div>
			<?php endif; ?>
		</aside>
	<?php endif; ?>
</div>
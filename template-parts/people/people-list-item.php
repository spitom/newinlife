<?php
/**
 * Compact People directory row.
 *
 * @package newinlife
 */

defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

$title = function_exists( 'inlife_get_person_display_name' )
	? inlife_get_person_display_name( $post_id )
	: get_the_title( $post_id );

$position   = function_exists( 'get_field' ) ? get_field( 'person_position', $post_id ) : '';
$email      = function_exists( 'get_field' ) ? get_field( 'person_email', $post_id ) : '';
$phone      = function_exists( 'get_field' ) ? get_field( 'person_phone', $post_id ) : '';
$room       = function_exists( 'get_field' ) ? get_field( 'person_room', $post_id ) : '';
$department = function_exists( 'get_field' ) ? get_field( 'person_department_label', $post_id ) : '';

$type_slug = '';

$terms = get_the_terms( $post_id, 'people_type' );
if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
	$type_slug = $terms[0]->slug;
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
				'id'    => $team_id,
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
				'id'    => $lab_id,
				'label' => get_the_title( $lab_id ),
				'url'   => get_permalink( $lab_id ),
			];
		}
	}
}

if ( empty( $relations ) && 'staff' === $type_slug && $department ) {
	$relations[] = [
		'id'    => 0,
		'label' => $department,
		'url'   => '',
	];
}

$relation_seen = [];
$relations     = array_values(
	array_filter(
		$relations,
		static function ( $relation ) use ( &$relation_seen ) {
			$key = $relation['id'] ? 'post_' . $relation['id'] : 'text_' . sanitize_title( $relation['label'] );

			if ( isset( $relation_seen[ $key ] ) ) {
				return false;
			}

			$relation_seen[ $key ] = true;
			return true;
		}
	)
);
?>

<article class="people-directory-row">
	<div class="people-directory-row__identity">
		<h2 class="people-directory-row__title">
			<?php if ( 'scientific' === $type_slug ) : ?>
				<a href="<?php the_permalink(); ?>" class="people-directory-row__title-link">
					<?php echo esc_html( $title ); ?>
				</a>
			<?php else : ?>
				<span class="people-directory-row__title-text">
					<?php echo esc_html( $title ); ?>
				</span>
			<?php endif; ?>
		</h2>

		<?php if ( $position ) : ?>
			<p class="people-directory-row__position">
				<?php echo esc_html( $position ); ?>
			</p>
		<?php endif; ?>

		<?php if ( 'scientific' === $type_slug ) : ?>
			<p class="people-directory-row__profile">
				<a href="<?php the_permalink(); ?>" class="people-directory-row__profile-link c-readmore">
					<?php echo esc_html( inlife_t( 'Zobacz profil' ) ); ?>
					<span class="c-readmore__icon" aria-hidden="true">→</span>
				</a>
			</p>
		<?php endif; ?>
	</div>

	<?php if ( ! empty( $relations ) ) : ?>
		<div class="people-directory-row__affiliation">
			<?php foreach ( $relations as $index => $relation ) : ?>
				<?php if ( $index > 0 ) : ?>
					<span class="people-directory-row__separator" aria-hidden="true">·</span>
				<?php endif; ?>

				<?php if ( ! empty( $relation['url'] ) ) : ?>
					<a href="<?php echo esc_url( $relation['url'] ); ?>" class="people-directory-row__relation-link">
						<?php echo esc_html( $relation['label'] ); ?>
					</a>
				<?php else : ?>
					<span class="people-directory-row__relation-text">
						<?php echo esc_html( $relation['label'] ); ?>
					</span>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<?php if ( $email || $phone || $room ) : ?>
		<div class="people-directory-row__contact">
			<?php if ( $email ) : ?>
				<span class="people-directory-row__contact-item">
					<?php
					echo inlife_render_obfuscated_email_link(
						$email,
						'people-directory-row__email-link'
					); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					?>
				</span>
			<?php endif; ?>

			<?php if ( $phone ) : ?>
				<span class="people-directory-row__contact-item">
					<a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $phone ) ); ?>" class="people-directory-row__phone-link">
						<?php echo esc_html( $phone ); ?>
					</a>
				</span>
			<?php endif; ?>

			<?php if ( $room ) : ?>
				<span class="people-directory-row__contact-item people-directory-row__contact-item--room">
					<span class="people-directory-row__room-label">
						<?php echo esc_html( inlife_t( 'Pokój' ) ); ?>:
					</span>
					<?php echo esc_html( $room ); ?>
				</span>
			<?php endif; ?>
		</div>
	<?php endif; ?>
</article>


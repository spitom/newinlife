<?php
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
$short_bio  = function_exists( 'get_field' ) ? get_field( 'person_short_bio', $post_id ) : '';

$type_label = '';
$type_slug  = '';

$terms = get_the_terms( $post_id, 'people_type' );
if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
	$type_label = $terms[0]->name;
	$type_slug  = $terms[0]->slug;
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
?>

<article class="people-list-item">
	<div class="people-list-item__main">
		<div class="people-list-item__head">
			<?php if ( $type_label ) : ?>
				<p class="people-list-item__type people-list-item__type--<?php echo esc_attr( $type_slug ); ?>">
					<?php echo esc_html( $type_label ); ?>
				</p>
			<?php endif; ?>

			<h2 class="people-list-item__title">
                <?php if ( 'scientific' === $type_slug ) : ?>
                    <a href="<?php the_permalink(); ?>" class="people-list-item__title-link">
                        <?php echo esc_html( $title ); ?>
                    </a>
                <?php else : ?>
                    <span class="people-list-item__title-text"><?php echo esc_html( $title ); ?></span>
                <?php endif; ?>
            </h2>

			<?php if ( $position ) : ?>
				<p class="people-list-item__position"><?php echo esc_html( $position ); ?></p>
			<?php endif; ?>
		</div>

		<?php if ( 'scientific' === $type_slug && $short_bio ) : ?>
			<p class="people-list-item__excerpt">
				<?php echo esc_html( $short_bio ); ?>
			</p>
		<?php endif; ?>

		<?php if ( ! empty( $teams ) || ! empty( $labs ) || ( 'staff' === $type_slug && $department ) ) : ?>
			<div class="people-list-item__relations">
				<?php if ( ! empty( $teams ) ) : ?>
					<div class="people-list-item__relation-group">
						<span class="people-list-item__relation-label"><?php esc_html_e( 'Zespół', 'newinlife' ); ?></span>
						<div class="people-list-item__relation-links">
							<?php foreach ( $teams as $team_id ) : ?>
								<a href="<?php echo esc_url( get_permalink( $team_id ) ); ?>" class="people-list-item__relation-link">
									<?php echo esc_html( get_the_title( $team_id ) ); ?>
								</a>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $labs ) ) : ?>
					<div class="people-list-item__relation-group">
						<span class="people-list-item__relation-label"><?php esc_html_e( 'Laboratorium', 'newinlife' ); ?></span>
						<div class="people-list-item__relation-links">
							<?php foreach ( $labs as $lab_id ) : ?>
								<a href="<?php echo esc_url( get_permalink( $lab_id ) ); ?>" class="people-list-item__relation-link">
									<?php echo esc_html( get_the_title( $lab_id ) ); ?>
								</a>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endif; ?>

				<?php if ( 'staff' === $type_slug && $department ) : ?>
					<div class="people-list-item__relation-group">
						<span class="people-list-item__relation-label"><?php esc_html_e( 'Dział / jednostka', 'newinlife' ); ?></span>
						<div class="people-list-item__relation-links">
							<span class="people-list-item__relation-text"><?php echo esc_html( $department ); ?></span>
						</div>
					</div>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>

	<div class="people-list-item__meta">
		<?php if ( $email ) : ?>
			<p class="people-list-item__meta-row">
				<span class="people-list-item__meta-label"><?php esc_html_e( 'E-mail', 'newinlife' ); ?></span>
				<a href="mailto:<?php echo esc_attr( antispambot( $email ) ); ?>">
					<?php echo esc_html( antispambot( $email ) ); ?>
				</a>
			</p>
		<?php endif; ?>

		<?php if ( $phone ) : ?>
			<p class="people-list-item__meta-row">
				<span class="people-list-item__meta-label"><?php esc_html_e( 'Telefon', 'newinlife' ); ?></span>
				<a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $phone ) ); ?>">
					<?php echo esc_html( $phone ); ?>
				</a>
			</p>
		<?php endif; ?>

		<?php if ( $room ) : ?>
			<p class="people-list-item__meta-row">
				<span class="people-list-item__meta-label"><?php esc_html_e( 'Pokój', 'newinlife' ); ?></span>
				<span><?php echo esc_html( $room ); ?></span>
			</p>
		<?php endif; ?>

		<?php if ( 'scientific' === $type_slug ) : ?>
            <p class="people-list-item__cta-wrap">
                <a href="<?php the_permalink(); ?>" class="people-list-item__cta">
                    <?php esc_html_e( 'Zobacz profil', 'newinlife' ); ?>
                </a>
            </p>
        <?php endif; ?>
	</div>
</article>
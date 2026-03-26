<?php
defined( 'ABSPATH' ) || exit;

$manager_id = function_exists( 'inlife_get_laboratory_manager' )
	? inlife_get_laboratory_manager( get_the_ID() )
	: null;

$members = function_exists( 'inlife_get_laboratory_members' )
	? inlife_get_laboratory_members( get_the_ID() )
	: array();

if ( $manager_id ) {
	$members = array_values(
		array_filter(
			$members,
			static fn( $member_id ) => (int) $member_id !== (int) $manager_id
		)
	);
}
?>

<div class="lab-section-block">
	<header class="section-heading">
		<h2 class="section-title">
			<?php echo esc_html( inlife_t( 'Skład osobowy' ) ); ?>
		</h2>
	</header>

	<?php if ( $manager_id || ! empty( $members ) ) : ?>

		<div class="lab-members-list">

			<?php if ( $manager_id ) : ?>
				<?php
				$name = function_exists( 'inlife_get_person_display_name' )
					? inlife_get_person_display_name( $manager_id )
					: get_the_title( $manager_id );

				$link     = get_permalink( $manager_id );
				$position = function_exists( 'get_field' ) ? get_field( 'person_position', $manager_id ) : '';
				$email    = function_exists( 'get_field' ) ? get_field( 'person_email', $manager_id ) : '';
				?>

				<article class="lab-member-mini-card lab-member-mini-card--manager">
					<h3 class="lab-member-mini-card__name">
						<a href="<?php echo esc_url( $link ); ?>" class="lab-member-mini-card__link">
							<?php echo esc_html( $name ); ?>
						</a>

						<span class="lab-member-mini-card__role-badge">
							<?php echo esc_html( inlife_t( 'Kierownik' ) ); ?>
						</span>
					</h3>

					<?php if ( $position ) : ?>
						<p class="lab-member-mini-card__position">
							<?php echo esc_html( $position ); ?>
						</p>
					<?php endif; ?>

					<?php if ( $email ) : ?>
						<p class="lab-member-mini-card__meta">
							<?php echo esc_html( antispambot( $email ) ); ?>
						</p>
					<?php endif; ?>

					<a href="<?php echo esc_url( $link ); ?>" class="lab-member-mini-card__cta">
						<?php echo esc_html( inlife_t( 'Zobacz profil' ) ); ?> →
					</a>
				</article>
			<?php endif; ?>

			<?php foreach ( $members as $member_id ) : ?>
				<?php
				$name = function_exists( 'inlife_get_person_display_name' )
					? inlife_get_person_display_name( $member_id )
					: get_the_title( $member_id );

				$link     = get_permalink( $member_id );
				$position = function_exists( 'get_field' ) ? get_field( 'person_position', $member_id ) : '';
				$email    = function_exists( 'get_field' ) ? get_field( 'person_email', $member_id ) : '';
				?>

				<article class="lab-member-mini-card">
					<h3 class="lab-member-mini-card__name">
						<a href="<?php echo esc_url( $link ); ?>" class="lab-member-mini-card__link">
							<?php echo esc_html( $name ); ?>
						</a>
					</h3>

					<?php if ( $position ) : ?>
						<p class="lab-member-mini-card__position">
							<?php echo esc_html( $position ); ?>
						</p>
					<?php endif; ?>

					<?php if ( $email ) : ?>
						<p class="lab-member-mini-card__meta">
							<?php echo esc_html( antispambot( $email ) ); ?>
						</p>
					<?php endif; ?>

					<a href="<?php echo esc_url( $link ); ?>" class="lab-member-mini-card__cta">
						<?php echo esc_html( inlife_t( 'Zobacz profil' ) ); ?> →
					</a>
				</article>
			<?php endforeach; ?>

		</div>

	<?php else : ?>

		<div class="team-empty-state">
			<p><?php echo esc_html( inlife_t( 'Skład osobowy nie został jeszcze uzupełniony.' ) ); ?></p>
		</div>

	<?php endif; ?>
</div>
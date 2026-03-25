<?php
defined( 'ABSPATH' ) || exit;

$leader_id = function_exists( 'inlife_get_team_leader' )
	? inlife_get_team_leader( get_the_ID() )
	: null;

$members = function_exists( 'inlife_get_team_members' )
	? inlife_get_team_members( get_the_ID() )
	: array();

if ( $leader_id ) {
	$members = array_values(
		array_filter(
			$members,
			static fn( $member_id ) => (int) $member_id !== (int) $leader_id
		)
	);
}
?>

<div class="team-section-block">
	<header class="section-heading">
		<h2 class="section-title">
			<?php echo esc_html( inlife_t( 'Skład zespołu' ) ); ?>
		</h2>
	</header>

	<?php if ( ! empty( $members ) ) : ?>

		<div class="team-members-list">
			<?php foreach ( $members as $member_id ) : ?>
				<?php
				$name     = get_the_title( $member_id );
				$link     = get_permalink( $member_id );
				$position = function_exists( 'get_field' ) ? get_field( 'person_position', $member_id ) : '';
				$email    = function_exists( 'get_field' ) ? get_field( 'person_email', $member_id ) : '';
				?>

				<article class="team-member-mini-card">
					<h3 class="team-member-mini-card__name">
						<a href="<?php echo esc_url( $link ); ?>" class="team-member-mini-card__link">
							<?php echo esc_html( $name ); ?>
						</a>
					</h3>

					<?php if ( $position ) : ?>
						<p class="team-member-mini-card__position">
							<?php echo esc_html( $position ); ?>
						</p>
					<?php endif; ?>

					<?php if ( $email ) : ?>
						<p class="team-member-mini-card__meta">
							<?php echo esc_html( antispambot( $email ) ); ?>
						</p>
					<?php endif; ?>
				</article>
			<?php endforeach; ?>
		</div>

	<?php else : ?>

		<div class="team-empty-state">
			<p><?php esc_html_e( 'Brak przypisanych członków zespołu.', 'newinlife' ); ?></p>
		</div>

	<?php endif; ?>
</div>
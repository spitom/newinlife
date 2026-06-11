<?php
defined( 'ABSPATH' ) || exit;

$leader_id = function_exists( 'inlife_get_team_leader' )
	? inlife_get_team_leader( get_the_ID() )
	: null;

$members = function_exists( 'inlife_get_team_members' )
	? inlife_get_team_members( get_the_ID() )
	: array();

if ( ! is_array( $members ) ) {
	$members = array();
}

if ( $leader_id ) {
	$members = array_values(
		array_filter(
			$members,
			static fn( $member_id ) => (int) $member_id !== (int) $leader_id
		)
	);
}

if ( ! empty( $members ) ) {
	usort(
		$members,
		static function ( $a, $b ) {
			$get_weight = static function ( $person_id ): int {
				$position = function_exists( 'get_field' )
					? (string) get_field( 'person_position', (int) $person_id )
					: '';

				if ( '' === $position ) {
					return 999;
				}

				$position = wp_strip_all_tags( $position );
				$position = remove_accents( mb_strtolower( $position ) );

				$map = array(
					'profesor'   => 10,
					'adiunkt'    => 20,
					'asystent'   => 30,
					'specjalist' => 40,
					'technolog'  => 50,
					'doktorant'  => 60,
				);

				foreach ( $map as $needle => $weight ) {
					if ( false !== strpos( $position, $needle ) ) {
						return $weight;
					}
				}

				return 999;
			};

			$weight_a = $get_weight( (int) $a );
			$weight_b = $get_weight( (int) $b );

			if ( $weight_a !== $weight_b ) {
				return $weight_a <=> $weight_b;
			}

			$name_a = function_exists( 'inlife_get_person_display_name' )
				? inlife_get_person_display_name( (int) $a )
				: get_the_title( (int) $a );

			$name_b = function_exists( 'inlife_get_person_display_name' )
				? inlife_get_person_display_name( (int) $b )
				: get_the_title( (int) $b );

			return strcasecmp( $name_a, $name_b );
		}
	);
}
?>

<section class="team-members-section" aria-labelledby="team-members-title">
	<header class="section-heading">
		<h2 id="team-members-title" class="section-title">
			<?php echo esc_html( inlife_t( 'Skład zespołu' ) ); ?>
		</h2>
	</header>

	<?php if ( ! empty( $members ) ) : ?>

		<div class="team-members-list">
			<?php foreach ( $members as $member_id ) : ?>
				<?php
				$member_id = (int) $member_id;

				$name = function_exists( 'inlife_get_person_display_name' )
					? inlife_get_person_display_name( $member_id )
					: get_the_title( $member_id );

				// $link     = get_permalink( $member_id );
				$position = function_exists( 'get_field' ) ? get_field( 'person_position', $member_id ) : '';
				$email    = function_exists( 'get_field' ) ? get_field( 'person_email', $member_id ) : '';
				$orcid        = function_exists( 'get_field' ) ? get_field( 'person_orcid', $member_id ) : '';
				$researchgate = function_exists( 'get_field' ) ? get_field( 'person_researchgate', $member_id ) : '';
				$linkedin     = function_exists( 'get_field' ) ? get_field( 'person_linkedin', $member_id ) : '';
				$has_image    = has_post_thumbnail( $member_id );
				?>

				<article class="team-member-tile">

					<div class="team-member-tile__media">
						<?php if ( $has_image ) : ?>
							<?php
							echo get_the_post_thumbnail(
								$member_id,
								'thumbnail',
								array(
									'class'   => 'team-member-tile__image',
									'loading' => 'lazy',
								)
							);
							?>
						<?php else : ?>
							<span class="team-member-tile__placeholder" aria-hidden="true">
								<i class="bi bi-person-fill"></i>
							</span>
						<?php endif; ?>
					</div>

					<h3 class="team-member-tile__name">
						<?php echo esc_html( $name ); ?>
					</h3>

					<?php if ( $position ) : ?>
						<p class="team-member-tile__position">
							<?php echo esc_html( $position ); ?>
						</p>
					<?php endif; ?>

					<?php if ( $email ) : ?>
						<p class="team-member-tile__meta">
							<a href="mailto:<?php echo esc_attr( $email ); ?>">
								<?php echo esc_html( function_exists( 'inlife_mask_email' ) ? inlife_mask_email( $email ) : str_replace( '@', ' [at] ', $email ) ); ?>
							</a>
						</p>
					<?php endif; ?>

					<?php if ( $orcid || $researchgate || $linkedin ) : ?>
						<div class="team-person-socials team-person-socials--member" aria-label="<?php echo esc_attr__( 'Profile naukowe i społecznościowe', 'newinlife-child' ); ?>">
							<?php if ( $orcid ) : ?>
								<a class="team-person-socials__link team-person-socials__link--orcid" href="<?php echo esc_url( $orcid ); ?>" target="_blank" rel="noopener noreferrer" aria-label="ORCID">
									<span class="team-person-socials__icon" aria-hidden="true">iD</span>
									<span class="visually-hidden">ORCID</span>
								</a>
							<?php endif; ?>

							<?php if ( $researchgate ) : ?>
								<a class="team-person-socials__link team-person-socials__link--researchgate" href="<?php echo esc_url( $researchgate ); ?>" target="_blank" rel="noopener noreferrer" aria-label="ResearchGate">
									<span class="team-person-socials__icon" aria-hidden="true">R<sup>G</sup></span>
									<span class="visually-hidden">ResearchGate</span>
								</a>
							<?php endif; ?>

							<?php if ( $linkedin ) : ?>
								<a class="team-person-socials__link team-person-socials__link--linkedin" href="<?php echo esc_url( $linkedin ); ?>" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
									<span class="team-person-socials__icon" aria-hidden="true">
										<i class="bi bi-linkedin"></i>
									</span>
									<span class="visually-hidden">LinkedIn</span>
								</a>
							<?php endif; ?>
						</div>
					<?php endif; ?>

					<!-- <a href="<?php echo esc_url( $link ); ?>" class="team-member-tile__cta c-readmore">
						<span class="c-readmore__label">
							<?php echo esc_html( inlife_t( 'Zobacz profil' ) ); ?>
						</span>
						<span class="c-readmore__icon" aria-hidden="true">→</span>
					</a> -->
				</article>
			<?php endforeach; ?>
		</div>

	<?php else : ?>

		<div class="team-empty-state">
			<p><?php esc_html_e( 'Brak przypisanych członków zespołu.', 'newinlife' ); ?></p>
		</div>

	<?php endif; ?>
</section>
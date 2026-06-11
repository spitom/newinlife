<?php
defined( 'ABSPATH' ) || exit;

$leader_id = function_exists( 'inlife_get_team_leader' )
	? inlife_get_team_leader( get_the_ID() )
	: null;
?>

<section class="team-leader-section" aria-labelledby="team-leader-title">
	<header class="section-heading">
		<h2 id="team-leader-title" class="section-title">
			<?php echo esc_html( inlife_t( 'Kierownik zespołu' ) ); ?>
		</h2>
	</header>

	<?php if ( $leader_id ) : ?>
		<?php
		$name = function_exists( 'inlife_get_person_display_name' )
			? inlife_get_person_display_name( $leader_id )
			: get_the_title( $leader_id );

		$position      = function_exists( 'get_field' ) ? get_field( 'person_position', $leader_id ) : '';
		$short_bio     = function_exists( 'get_field' ) ? get_field( 'person_short_bio', $leader_id ) : '';
		$email         = function_exists( 'get_field' ) ? get_field( 'person_email', $leader_id ) : '';
		$phone         = function_exists( 'get_field' ) ? get_field( 'person_phone', $leader_id ) : '';
		$orcid         = function_exists( 'get_field' ) ? get_field( 'person_orcid', $leader_id ) : '';
		$researchgate  = function_exists( 'get_field' ) ? get_field( 'person_researchgate', $leader_id ) : '';
		$linkedin      = function_exists( 'get_field' ) ? get_field( 'person_linkedin', $leader_id ) : '';

		$has_image = has_post_thumbnail( $leader_id );
		?>

		<div class="team-leader-card<?php echo $has_image ? '' : ' team-leader-card--no-media'; ?>">

			<?php if ( $has_image ) : ?>
				<div class="team-leader-card__media">
					<?php
					echo get_the_post_thumbnail(
						$leader_id,
						'medium',
						array(
							'class'   => 'team-leader-card__image',
							'loading' => 'lazy',
						)
					);
					?>
				</div>
			<?php endif; ?>

			<div class="team-leader-card__content">
				<p class="team-leader-card__eyebrow">
					<?php echo esc_html( inlife_t( 'Kierownik zespołu' ) ); ?>
				</p>

				<h3 class="team-leader-card__name"><?php echo esc_html( $name ); ?></h3>

				<?php if ( $position ) : ?>
					<p class="team-leader-card__role"><?php echo esc_html( $position ); ?></p>
				<?php endif; ?>

				<?php if ( $short_bio ) : ?>
					<div class="team-leader-card__bio">
						<?php echo wp_kses_post( wpautop( $short_bio ) ); ?>
					</div>
				<?php endif; ?>

				<?php if ( $email ) : ?>
					<p class="team-leader-card__meta">
						<a href="mailto:<?php echo esc_attr( $email ); ?>">
							<?php echo esc_html( function_exists( 'inlife_mask_email' ) ? inlife_mask_email( $email ) : str_replace( '@', ' [at] ', $email ) ); ?>
						</a>
					</p>
				<?php endif; ?>

				<?php if ( $phone ) : ?>
					<p class="team-leader-card__meta">
						<a href="<?php echo esc_url( 'tel:' . preg_replace( '/[^0-9+]/', '', $phone ) ); ?>">
							<?php echo esc_html( $phone ); ?>
						</a>
					</p>
				<?php endif; ?>

				<?php if ( $orcid || $researchgate || $linkedin ) : ?>
					<div class="team-person-socials" aria-label="<?php echo esc_attr__( 'Profile naukowe i społecznościowe', 'newinlife-child' ); ?>">
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

				<!-- <a href="<?php echo esc_url( $link ); ?>" class="team-leader-card__link c-readmore">
					<span class="c-readmore__label">
						<?php echo esc_html( inlife_t( 'Zobacz profil' ) ); ?>
					</span>
					<span class="c-readmore__icon" aria-hidden="true">→</span>
				</a> -->
			</div>
		</div>

	<?php else : ?>
		<div class="team-empty-state">
			<p><?php echo esc_html( inlife_t( 'Nie przypisano kierownika zespołu.' ) ); ?></p>
		</div>
	<?php endif; ?>
</section>
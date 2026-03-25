<?php
defined( 'ABSPATH' ) || exit;

$leader_id = function_exists( 'inlife_get_team_leader' )
	? inlife_get_team_leader( get_the_ID() )
	: null;
?>

<div class="team-section-block team-section-block--leader">
	<header class="section-heading">
		<h2 class="section-title">
			<?php echo esc_html( inlife_t( 'Kierownik zespołu' ) ); ?>
		</h2>
	</header>

	<?php if ( $leader_id ) : ?>
		<?php
		$name      = get_the_title( $leader_id );
		$link      = get_permalink( $leader_id );
		$position  = function_exists( 'get_field' ) ? get_field( 'person_position', $leader_id ) : '';
		$short_bio = function_exists( 'get_field' ) ? get_field( 'person_short_bio', $leader_id ) : '';
		$email     = function_exists( 'get_field' ) ? get_field( 'person_email', $leader_id ) : '';
		?>

		<div class="team-leader-card">
			<div class="team-leader-card__media">
				<?php if ( has_post_thumbnail( $leader_id ) ) : ?>
					<?php
					echo get_the_post_thumbnail(
						$leader_id,
						'medium',
						[
							'class'   => 'team-leader-card__image',
							'loading' => 'lazy',
						]
					);
					?>
				<?php else : ?>
					<div class="team-leader-card__placeholder" aria-hidden="true"></div>
				<?php endif; ?>
			</div>

			<div class="team-leader-card__content">
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
						<?php echo esc_html( antispambot( $email ) ); ?>
					</p>
				<?php endif; ?>

				<a href="<?php echo esc_url( $link ); ?>" class="team-leader-card__link">
					<?php echo esc_html( inlife_t( 'Zobacz profil' ) ); ?> →
				</a>
			</div>
		</div>

	<?php else : ?>
		<div class="team-empty-state">
			<p><?php esc_html_e( 'Nie przypisano kierownika zespołu.', 'newinlife' ); ?></p>
		</div>
	<?php endif; ?>
</div>
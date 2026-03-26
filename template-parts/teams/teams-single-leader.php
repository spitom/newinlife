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
		$name = function_exists( 'inlife_get_person_display_name' )
			? inlife_get_person_display_name( $leader_id )
			: get_the_title( $leader_id );

		$link      = get_permalink( $leader_id );
		$position  = function_exists( 'get_field' ) ? get_field( 'person_position', $leader_id ) : '';
		$short_bio = function_exists( 'get_field' ) ? get_field( 'person_short_bio', $leader_id ) : '';
		$email     = function_exists( 'get_field' ) ? get_field( 'person_email', $leader_id ) : '';

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
				<p class="team-leader-card__badge">
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
						<?php echo esc_html( antispambot( $email ) ); ?>
					</p>
				<?php endif; ?>

				<a href="<?php echo esc_url( $link ); ?>" class="team-leader-card__link">
					<?php echo esc_html( inlife_t( 'Zobacz profil' ) ); ?> <span aria-hidden="true">→</span>
				</a>
			</div>
		</div>

	<?php else : ?>
		<div class="team-empty-state">
			<p><?php echo esc_html( inlife_t( 'Nie przypisano kierownika zespołu.' ) ); ?></p>
		</div>
	<?php endif; ?>
</div>
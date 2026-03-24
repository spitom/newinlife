<?php
defined( 'ABSPATH' ) || exit;

$team_people = function_exists( 'inlife_get_team_people' )
	? inlife_get_team_people( get_the_ID() )
	: array();

$leader = $team_people['leader'] ?? null;
?>

<div class="team-leader">
	<header class="section-heading">
		<h2 class="section-title"><?php esc_html_e( 'Kierownik zespołu', 'newinlife' ); ?></h2>
	</header>

	<?php if ( $leader instanceof WP_Post ) : ?>
		<?php
		$leader_id    = $leader->ID;
		$leader_name  = get_the_title( $leader_id );
		$leader_link  = get_permalink( $leader_id );
		$leader_role  = function_exists( 'get_field' ) ? get_field( 'person_position', $leader_id ) : '';
		$leader_bio   = function_exists( 'get_field' ) ? get_field( 'person_short_bio', $leader_id ) : '';
		$leader_thumb = get_the_post_thumbnail( $leader_id, 'large', [ 'class' => 'team-leader__image' ] );
		?>

		<div class="team-leader__card">
			<div class="team-leader__media">
				<?php if ( $leader_thumb ) : ?>
					<?php echo $leader_thumb; ?>
				<?php else : ?>
					<div class="team-leader__placeholder" aria-hidden="true"></div>
				<?php endif; ?>
			</div>

			<div class="team-leader__content">
				<h3 class="team-leader__name"><?php echo esc_html( $leader_name ); ?></h3>

				<p class="team-leader__role">
					<?php echo esc_html( $leader_role ? $leader_role : __( 'Lider zespołu', 'newinlife' ) ); ?>
				</p>

				<?php if ( $leader_bio ) : ?>
					<div class="team-leader__bio">
						<?php echo wp_kses_post( wpautop( $leader_bio ) ); ?>
					</div>
				<?php else : ?>
					<p class="team-leader__bio">
						<?php esc_html_e( 'Opis kierownika zespołu zostanie uzupełniony po wdrożeniu danych osobowych.', 'newinlife' ); ?>
					</p>
				<?php endif; ?>

				<a href="<?php echo esc_url( $leader_link ); ?>" class="team-leader__link">
					<?php esc_html_e( 'Zobacz profil', 'newinlife' ); ?> →
				</a>
			</div>
		</div>

	<?php else : ?>
		<div class="team-empty-state">
			<p><?php esc_html_e( 'Kierownik zespołu nie został jeszcze przypisany.', 'newinlife' ); ?></p>
		</div>
	<?php endif; ?>
</div>
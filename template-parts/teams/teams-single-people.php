<?php
defined( 'ABSPATH' ) || exit;

$team_people = function_exists( 'inlife_get_team_people' )
	? inlife_get_team_people( get_the_ID() )
	: array();

$members = $team_people['members'] ?? array();
?>

<div class="team-people">
	<header class="section-heading">
		<h2 class="section-title"><?php esc_html_e( 'Skład zespołu', 'newinlife' ); ?></h2>
	</header>

	<?php if ( ! empty( $members ) ) : ?>
		<div class="team-people__grid">
			<?php foreach ( $members as $member ) : ?>
				<?php
				setup_postdata( $member );
				get_template_part(
					'template-parts/people/people',
					'card',
					array(
						'featured'  => false,
						'show_type' => false,
						'cta_label' => __( 'Zobacz profil', 'newinlife' ),
					)
				);
				?>
			<?php endforeach; wp_reset_postdata(); ?>
		</div>
	<?php else : ?>
		<div class="team-empty-state">
			<p><?php esc_html_e( 'Skład zespołu nie został jeszcze uzupełniony.', 'newinlife' ); ?></p>
		</div>
	<?php endif; ?>
</div>
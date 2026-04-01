<?php
defined( 'ABSPATH' ) || exit;

$team_id = $args['team_id'] ?? get_the_ID();
$team_id = (int) $team_id;

if ( ! $team_id ) {
	return;
}

$current_year = function_exists( 'inlife_get_current_team_publication_year_filter' )
	? inlife_get_current_team_publication_year_filter()
	: '';

$years = function_exists( 'inlife_get_team_publication_years' )
	? inlife_get_team_publication_years( $team_id )
	: array();

$grouped_publications = function_exists( 'inlife_get_team_grouped_publications' )
	? inlife_get_team_grouped_publications( $team_id, $current_year )
	: array();

$base_url = get_permalink( $team_id );
?>

<div id="team-publications-section" class="team-publications">
	<?php if ( ! empty( $years ) ) : ?>
		<?php
		get_template_part(
			'template-parts/publications/publications',
			'team-filter',
			array(
				'years'        => $years,
				'current_year' => $current_year,
				'base_url'     => $base_url,
			)
		);
		?>
	<?php endif; ?>

	<?php
	get_template_part(
		'template-parts/publications/publications',
		'team-list',
		array(
			'grouped_publications' => $grouped_publications,
			'current_year'         => $current_year,
		)
	);
	?>
</div>
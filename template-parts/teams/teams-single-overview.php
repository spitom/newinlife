<?php
defined( 'ABSPATH' ) || exit;

$team_id = get_the_ID();

$team_description = function_exists( 'get_field' ) ? get_field( 'team_description', $team_id ) : '';
$description_content = $team_description ? $team_description : get_the_content();

$description_plain = trim(
	wp_strip_all_tags(
		html_entity_decode(
			(string) $description_content,
			ENT_QUOTES,
			get_bloginfo( 'charset' )
		)
	)
);

$show_description_toggle = mb_strlen( $description_plain ) > 650;
?>

<section class="team-overview" aria-labelledby="team-overview-title">
	<div class="team-overview__main c-surface c-surface--panel">
		<header class="section-heading">
			<h2 id="team-overview-title" class="section-title">
				<?php echo esc_html( inlife_t( 'O zespole' ) ); ?>
			</h2>
		</header>

		<div
			class="team-overview__content entry-content<?php echo $show_description_toggle ? ' is-collapsed' : ''; ?>"
			data-team-description
			id="teamDescriptionContent"
		>
			<?php echo wp_kses_post( $description_content ); ?>
		</div>

		<?php if ( $show_description_toggle ) : ?>
			<div class="team-overview__actions">
				<button
					type="button"
					class="team-overview__toggle"
					data-team-description-toggle
					aria-expanded="false"
					aria-controls="teamDescriptionContent"
				>
					<span class="team-overview__toggle-text team-overview__toggle-text--more">
						<?php echo esc_html( inlife_t( 'Pokaż więcej' ) ); ?>
					</span>
					<span class="team-overview__toggle-text team-overview__toggle-text--less">
						<?php echo esc_html( inlife_t( 'Pokaż mniej' ) ); ?>
					</span>
					<span class="team-overview__toggle-arrow" aria-hidden="true">↓</span>
				</button>
			</div>
		<?php endif; ?>
	</div>
</section>
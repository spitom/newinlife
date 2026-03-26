<?php
defined( 'ABSPATH' ) || exit;

$team_id = get_the_ID();

$team_description = function_exists( 'get_field' ) ? get_field( 'team_description', $team_id ) : '';
$profile_text     = function_exists( 'get_field' ) ? get_field( 'team_profile', $team_id ) : '';
$research_text    = function_exists( 'get_field' ) ? get_field( 'team_research_summary', $team_id ) : '';

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

/**
 * Próg pokazania przycisku.
 * Możesz go później podbić/obniżyć, np. 500 / 650 / 800.
 */
$show_description_toggle = mb_strlen( $description_plain ) > 650;

$terms = get_the_terms( $team_id, 'team_area' );
?>

<div class="team-overview">
	<div class="row g-4 g-xl-5">

		<div class="col-lg-8">
			<div class="team-overview__main">
				<header class="section-heading">
					<h2 class="section-title"><?php echo esc_html( inlife_t( 'Opis działalności' ) ); ?></h2>
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
		</div>

		<div class="col-lg-4">
			<aside class="team-overview__aside">

				<div class="team-info-card">
					<h3 class="team-info-card__title">
						<?php echo esc_html( inlife_t( 'Profil jednostki' ) ); ?>
					</h3>

					<div class="team-info-card__text">
						<?php if ( $profile_text ) : ?>
							<?php echo wp_kses_post( wpautop( $profile_text ) ); ?>
						<?php else : ?>
							<p><?php echo esc_html( inlife_t( 'Szczegółowe informacje o zakresie działalności zespołu zostaną uzupełnione w kolejnym etapie wdrożenia.' ) ); ?></p>
						<?php endif; ?>
					</div>
				</div>

				<div class="team-info-card">
					<h3 class="team-info-card__title">
						<?php echo esc_html( inlife_t( 'Obszary badawcze' ) ); ?>
					</h3>

					<div class="team-info-card__text">
						<?php if ( $research_text ) : ?>
							<?php echo wp_kses_post( wpautop( $research_text ) ); ?>
						<?php elseif ( ! empty( $terms ) && ! is_wp_error( $terms ) ) : ?>
							<ul class="team-info-card__list">
								<?php foreach ( $terms as $term ) : ?>
									<li><?php echo esc_html( $term->name ); ?></li>
								<?php endforeach; ?>
							</ul>
						<?php else : ?>
							<p><?php echo esc_html( inlife_t( 'Ta sekcja będzie rozwijana wraz z docelowymi polami i treściami redakcyjnymi.' ) ); ?></p>
						<?php endif; ?>
					</div>
				</div>

			</aside>
		</div>

	</div>
</div>
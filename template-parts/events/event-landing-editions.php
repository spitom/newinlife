<?php
/**
 * Previous editions section for event landing pages.
 *
 * @package newinlife
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'get_field' ) ) {
	return;
}

$post_id  = get_the_ID();
$editions = get_field( 'event_landing_editions', $post_id );

if ( ! is_array( $editions ) || empty( $editions ) ) {
	return;
}

$editions = array_values(
	array_filter(
		$editions,
		static function ( $edition ) {
			return ! empty( $edition['event_landing_edition_year'] );
		}
	)
);

if ( empty( $editions ) ) {
	return;
}

usort(
	$editions,
	static function ( $a, $b ) {
		$year_a = absint( $a['event_landing_edition_year'] ?? 0 );
		$year_b = absint( $b['event_landing_edition_year'] ?? 0 );

		return $year_b <=> $year_a;
	}
);

$title = trim(
	(string) get_field( 'event_landing_editions_title', $post_id )
);

$lead = trim(
	(string) get_field( 'event_landing_editions_lead', $post_id )
);

if ( ! $title ) {
	$title = inlife_t( 'Materiały z poprzednich edycji' );
}
?>

<section
	id="materialy-konferencyjne"
	class="page-section event-landing-editions"
>
	<div class="inlife-container">

		<header class="event-landing-editions__header">
			<h2 class="event-landing-editions__title">
				<?php echo esc_html( $title ); ?>
			</h2>

			<?php if ( $lead ) : ?>
				<p class="event-landing-editions__lead">
					<?php echo esc_html( $lead ); ?>
				</p>
			<?php endif; ?>
		</header>

		<div class="event-landing-editions__grid">

			<?php foreach ( $editions as $edition ) : ?>
				<?php
				$year     = absint( $edition['event_landing_edition_year'] ?? 0 );
				$cover_id = absint( $edition['event_landing_edition_cover'] ?? 0 );
				$link     = $edition['event_landing_edition_link'] ?? null;

				$link_url    = '';
				$link_title  = '';
				$link_target = '';

				if ( is_array( $link ) ) {
					$link_url    = $link['url'] ?? '';
					$link_title  = $link['title'] ?? '';
					$link_target = $link['target'] ?? '';
				}
				?>

				<article class="event-edition-card">

					<?php if ( $cover_id ) : ?>
						<div class="event-edition-card__media">
							<?php
							echo wp_get_attachment_image(
								$cover_id,
								'medium_large',
								false,
								[
									'class'   => 'event-edition-card__image',
									'loading' => 'lazy',
								]
							);
							?>
						</div>
					<?php endif; ?>

					<div class="event-edition-card__body">
						<h3 class="event-edition-card__year">
							<?php echo esc_html( (string) $year ); ?>
						</h3>

						<?php if ( $link_url ) : ?>
							<a
								class="event-edition-card__link"
								href="<?php echo esc_url( $link_url ); ?>"
								<?php if ( $link_target ) : ?>
									target="<?php echo esc_attr( $link_target ); ?>"
								<?php endif; ?>
							>
								<?php
								echo esc_html(
									$link_title ?: inlife_t( 'Materiały konferencyjne' )
								);
								?>
							</a>
						<?php endif; ?>
					</div>

				</article>

			<?php endforeach; ?>

		</div>

	</div>
</section>
<?php
/**
 * Event type taxonomy content.
 *
 * @package newinlife
 */

defined( 'ABSPATH' ) || exit;

$term = $args['term'] ?? null;

if ( ! $term instanceof WP_Term ) {
	return;
}

$container = function_exists( 'inlife_container_class' )
	? inlife_container_class()
	: 'container';

$events_query = function_exists( 'inlife_get_events_for_type' )
	? inlife_get_events_for_type( $term->slug )
	: null;

$events_by_year   = [];
$upcoming_events = [];

$today = current_time( 'Ymd' );

if ( $events_query instanceof WP_Query && $events_query->have_posts() ) {
	while ( $events_query->have_posts() ) {
		$events_query->the_post();

		$post_id = get_the_ID();

		$start_date = function_exists( 'inlife_get_event_start_date' )
			? inlife_get_event_start_date( $post_id )
			: '';

		if ( ! preg_match( '/^\d{8}$/', $start_date ) ) {
			continue;
		}

		$year = substr( $start_date, 0, 4 );

		$events_by_year[ $year ][] = $post_id;

		$end_date = function_exists( 'get_field' )
			? trim( (string) get_field( 'event_end_date', $post_id ) )
			: '';

		$has_valid_end_date = (bool) preg_match(
			'/^\d{8}$/',
			$end_date
		);

		$is_upcoming = $has_valid_end_date
			? $end_date >= $today
			: $start_date >= $today;

		if ( $is_upcoming ) {
			$upcoming_events[] = $post_id;
		}
	}

	wp_reset_postdata();
}

krsort( $events_by_year );

usort(
	$upcoming_events,
	static function ( int $a, int $b ): int {
		$date_a = function_exists( 'inlife_get_event_start_date' )
			? inlife_get_event_start_date( $a )
			: '';

		$date_b = function_exists( 'inlife_get_event_start_date' )
			? inlife_get_event_start_date( $b )
			: '';

		return strcmp( $date_a, $date_b );
	}
);
$default_panel = '';

if ( ! empty( $upcoming_events ) ) {
	$default_panel = 'upcoming';
} elseif ( ! empty( $events_by_year ) ) {
	$first_year    = array_key_first( $events_by_year );
	$default_panel = 'year-' . $first_year;
}
?>

<section
	class="page-section page-section--event-type-content"
	aria-labelledby="event-type-content-heading"
>
	<div
		class="<?php echo esc_attr( $container ); ?>"
		data-inlife-tabs
		data-inlife-tabs-param="event_period"
		data-inlife-tabs-default="<?php echo esc_attr( $default_panel ); ?>"
	>

		<h2
			id="event-type-content-heading"
			class="visually-hidden"
		>
			<?php echo esc_html( $term->name ); ?>
		</h2>

		<?php
		$is_seminars = in_array(
			$term->slug,
			[
				'seminaria',
				'seminars',
			],
			true
		);

		$seminar_system_url = '';

		if ( $is_seminars && function_exists( 'pll_get_post' ) ) {
			$seminar_system_page = get_page_by_path( 'system-seminariow' );

			if ( $seminar_system_page instanceof WP_Post ) {
				$current_language = function_exists( 'pll_current_language' )
					? pll_current_language( 'slug' )
					: 'pl';

				$translated_page_id = pll_get_post(
					$seminar_system_page->ID,
					$current_language
				);

				if ( $translated_page_id ) {
					$seminar_system_url = get_permalink( $translated_page_id );
				}
			}
		}
		?>

		<?php if ( $seminar_system_url ) : ?>
			<p class="events-system-link">
				<a
					class="c-readmore"
					href="<?php echo esc_url( $seminar_system_url ); ?>"
				>
					<?php echo esc_html( inlife_t( 'System seminariów instytutowych' ) ); ?>
					<span class="c-readmore__icon" aria-hidden="true">→</span>
				</a>
			</p>
		<?php endif; ?>

		<?php if ( $default_panel ) : ?>

			<nav
				class="events-years-nav"
				role="tablist"
				aria-label="<?php echo esc_attr( inlife_t( 'Wybierz okres wydarzeń' ) ); ?>"
			>

				<?php if ( ! empty( $upcoming_events ) ) : ?>
					<?php $is_active = 'upcoming' === $default_panel; ?>

					<button
						id="events-tab-upcoming"
						class="events-years-nav__btn<?php echo $is_active ? ' is-active' : ''; ?>"
						type="button"
						role="tab"
						aria-controls="events-panel-upcoming"
						aria-selected="<?php echo $is_active ? 'true' : 'false'; ?>"
						tabindex="<?php echo $is_active ? '0' : '-1'; ?>"
						data-inlife-tab-trigger="upcoming"
					>
						<?php echo esc_html( inlife_t( 'Nadchodzące' ) ); ?>
					</button>
				<?php endif; ?>

				<?php foreach ( array_keys( $events_by_year ) as $year ) : ?>
					<?php
					$panel_key = 'year-' . $year;
					$is_active = $panel_key === $default_panel;
					?>

					<button
						id="events-tab-<?php echo esc_attr( $year ); ?>"
						class="events-years-nav__btn<?php echo $is_active ? ' is-active' : ''; ?>"
						type="button"
						role="tab"
						aria-controls="events-panel-<?php echo esc_attr( $year ); ?>"
						aria-selected="<?php echo $is_active ? 'true' : 'false'; ?>"
						tabindex="<?php echo $is_active ? '0' : '-1'; ?>"
						data-inlife-tab-trigger="<?php echo esc_attr( $panel_key ); ?>"
					>
						<?php echo esc_html( $year ); ?>
					</button>
				<?php endforeach; ?>

			</nav>

			<div class="events-periods">

				<?php if ( ! empty( $upcoming_events ) ) : ?>
					<?php $is_active = 'upcoming' === $default_panel; ?>

					<div
						id="events-panel-upcoming"
						class="events-period-panel<?php echo $is_active ? ' is-active' : ''; ?>"
						role="tabpanel"
						aria-labelledby="events-tab-upcoming"
						tabindex="0"
						data-inlife-tab-panel="upcoming"
						<?php echo $is_active ? '' : 'hidden'; ?>
					>
						<div class="events-list">
							<?php foreach ( $upcoming_events as $post_id ) : ?>
								<?php
								get_template_part(
									'template-parts/events/events-card',
									null,
									[
										'post_id'       => $post_id,
										'heading_level' => 3,
									]
								);
								?>
							<?php endforeach; ?>
						</div>
					</div>

				<?php endif; ?>

				<?php foreach ( $events_by_year as $year => $post_ids ) : ?>
					<?php
					$panel_key = 'year-' . $year;
					$is_active = $panel_key === $default_panel;
					?>

					<div
						id="events-panel-<?php echo esc_attr( $year ); ?>"
						class="events-period-panel<?php echo $is_active ? ' is-active' : ''; ?>"
						role="tabpanel"
						aria-labelledby="events-tab-<?php echo esc_attr( $year ); ?>"
						tabindex="0"
						data-inlife-tab-panel="<?php echo esc_attr( $panel_key ); ?>"
						<?php echo $is_active ? '' : 'hidden'; ?>
					>
						<div class="events-list">
							<?php foreach ( $post_ids as $post_id ) : ?>
								<?php
								get_template_part(
									'template-parts/events/events-card',
									null,
									[
										'post_id'       => $post_id,
										'heading_level' => 3,
									]
								);
								?>
							<?php endforeach; ?>
						</div>
					</div>

				<?php endforeach; ?>

			</div>

		<?php else : ?>

			<div class="events-empty-state">
				<p>
					<?php echo esc_html( inlife_t( 'Brak wydarzeń w tej kategorii.' ) ); ?>
				</p>
			</div>

		<?php endif; ?>

	</div>
</section>
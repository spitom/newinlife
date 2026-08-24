<?php
/**
 * Event card.
 *
 * @package newinlife
 */

defined( 'ABSPATH' ) || exit;

$post_id = isset( $args['post_id'] )
	? (int) $args['post_id']
	: get_the_ID();

$heading_level = isset( $args['heading_level'] )
	? (int) $args['heading_level']
	: 3;

$heading_tag = in_array( $heading_level, [ 2, 3, 4 ], true )
	? 'h' . $heading_level
	: 'h3';

$title = get_the_title( $post_id );

$event_link = function_exists( 'get_field' )
	? get_field( 'event_link', $post_id )
	: null;

$link_url = is_array( $event_link ) && ! empty( $event_link['url'] )
	? trim( (string) $event_link['url'] )
	: '';

$link_label = is_array( $event_link ) && ! empty( $event_link['title'] )
	? trim( (string) $event_link['title'] )
	: inlife_t( 'Szczegóły' );

$link_target = is_array( $event_link ) && '_blank' === ( $event_link['target'] ?? '' )
	? '_blank'
	: '';

$start_date = function_exists( 'inlife_get_event_start_date' )
	? inlife_get_event_start_date( $post_id )
	: '';

$end_date = function_exists( 'get_field' )
	? trim( (string) get_field( 'event_end_date', $post_id ) )
	: '';

$event_date = preg_match( '/^\d{8}$/', $start_date )
	? DateTimeImmutable::createFromFormat( '!Ymd', $start_date, wp_timezone() )
	: false;

$event_end_date = preg_match( '/^\d{8}$/', $end_date )
	? DateTimeImmutable::createFromFormat( '!Ymd', $end_date, wp_timezone() )
	: false;

$day_label             = '';
$month_label           = '';
$year_label            = '';
$is_date_range         = false;
$date_accessible_label = '';

if ( $event_date instanceof DateTimeImmutable ) {
	$start_month_label = mb_strtoupper(
		wp_date(
			'M',
			$event_date->getTimestamp(),
			wp_timezone()
		)
	);

	$day_label   = $event_date->format( 'd' );
	$month_label = $start_month_label;
	$year_label  = $event_date->format( 'Y' );

	if (
		$event_end_date instanceof DateTimeImmutable &&
		$event_end_date > $event_date
	) {
		$is_date_range = true;

		$end_month_label = mb_strtoupper(
			wp_date(
				'M',
				$event_end_date->getTimestamp(),
				wp_timezone()
			)
		);

		$same_year = (
			$event_date->format( 'Y' ) ===
			$event_end_date->format( 'Y' )
		);

		$same_month = (
			$event_date->format( 'Ym' ) ===
			$event_end_date->format( 'Ym' )
		);

		if ( $same_month ) {
			$day_label .= '–' . $event_end_date->format( 'd' );
		} elseif ( $same_year ) {
			$day_label = sprintf(
				'%1$s–%2$s',
				$event_date->format( 'd' ),
				$event_end_date->format( 'd' )
			);

			$month_label = sprintf(
				'%1$s–%2$s',
				$start_month_label,
				$end_month_label
			);
		} else {
			$day_label = sprintf(
				'%1$s %2$s %3$s–%4$s %5$s %6$s',
				$event_date->format( 'd' ),
				$start_month_label,
				$event_date->format( 'Y' ),
				$event_end_date->format( 'd' ),
				$end_month_label,
				$event_end_date->format( 'Y' )
			);

			$month_label = '';
			$year_label  = '';
		}

		$date_accessible_label = sprintf(
			'%1$s – %2$s',
			wp_date(
				'j F Y',
				$event_date->getTimestamp(),
				wp_timezone()
			),
			wp_date(
				'j F Y',
				$event_end_date->getTimestamp(),
				wp_timezone()
			)
		);
	}
}

$seminar_type = function_exists( 'get_field' )
	? trim( (string) get_field( 'event_seminar_type', $post_id ) )
	: '';

$event_time = function_exists( 'get_field' )
	? trim( (string) get_field( 'event_time', $post_id ) )
	: '';

$location = function_exists( 'get_field' )
	? trim( (string) get_field( 'event_location', $post_id ) )
	: '';

$lead = function_exists( 'get_field' )
	? trim( (string) get_field( 'event_lead', $post_id ) )
	: '';

$speaker = function_exists( 'get_field' )
	? trim( (string) get_field( 'event_speaker', $post_id ) )
	: '';

$status = function_exists( 'inlife_get_event_status' )
	? inlife_get_event_status( $post_id )
	: [
		'value' => 'scheduled',
		'label' => inlife_t( 'Zaplanowane' ),
	];

$event_types = get_the_terms( $post_id, 'event_type' );

$event_type = (
	! empty( $event_types ) &&
	! is_wp_error( $event_types )
)
	? $event_types[0]
	: null;
?>

<article class="event-item">

	<div class="event-item__date">
		<?php if ( $event_date instanceof DateTimeImmutable ) : ?>
			<time
				datetime="<?php echo esc_attr( $event_date->format( 'Y-m-d' ) ); ?>"
				<?php if ( $date_accessible_label ) : ?>
					aria-label="<?php echo esc_attr( $date_accessible_label ); ?>"
				<?php endif; ?>
			>
				<span class="event-item__date-day<?php echo $is_date_range ? ' event-item__date-day--range' : ''; ?>">
					<?php echo esc_html( $day_label ); ?>
				</span>

				<?php if ( $month_label ) : ?>
					<span class="event-item__date-month">
						<?php echo esc_html( $month_label ); ?>
					</span>
				<?php endif; ?>

				<?php if ( $year_label ) : ?>
					<span class="event-item__date-year">
						<?php echo esc_html( $year_label ); ?>
					</span>
				<?php endif; ?>
			</time>
		<?php endif; ?>
	</div>

	<div class="event-item__content">

		<div class="event-item__meta">
			<?php if ( $event_type instanceof WP_Term ) : ?>
				<span class="event-item__type">
					<?php echo esc_html( $event_type->name ); ?>
				</span>
			<?php endif; ?>

			<?php if ( in_array( $status['value'], [ 'cancelled', 'postponed' ], true ) ) : ?>
				<span class="event-item__status event-item__status--<?php echo esc_attr( $status['value'] ); ?>">
					<?php echo esc_html( $status['label'] ); ?>
				</span>
			<?php endif; ?>
		</div>

		<?php if ( $seminar_type ) : ?>
			<p class="event-item__seminar-type">
				<?php echo esc_html( $seminar_type ); ?>
			</p>
		<?php endif; ?>

		<<?php echo esc_html( $heading_tag ); ?> class="event-item__title">
			<?php if ( $link_url ) : ?>
				<a
					class="event-item__title-link"
					href="<?php echo esc_url( $link_url ); ?>"
					<?php if ( $link_target ) : ?>
						target="_blank"
						rel="noopener"
					<?php endif; ?>
				>
					<?php echo esc_html( $title ); ?>

					<?php if ( $link_target ) : ?>
						<span class="visually-hidden">
							<?php echo esc_html( inlife_t( '(otwiera w nowej karcie)' ) ); ?>
						</span>
					<?php endif; ?>
				</a>
			<?php else : ?>
				<?php echo esc_html( $title ); ?>
			<?php endif; ?>
		</<?php echo esc_html( $heading_tag ); ?>>

		<?php if ( $speaker ) : ?>
			<p class="event-item__speaker">
				<?php echo esc_html( $speaker ); ?>
			</p>
		<?php endif; ?>

		<?php if ( $event_time || $location ) : ?>
			<div class="event-item__details">
				<?php if ( $event_time ) : ?>
					<span class="event-item__time">
						<?php echo esc_html( $event_time ); ?>
					</span>
				<?php endif; ?>

				<?php if ( $location ) : ?>
					<span class="event-item__location">
						<?php echo esc_html( $location ); ?>
					</span>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( $lead ) : ?>
			<div class="event-item__lead">
				<?php echo wp_kses_post( $lead ); ?>
			</div>
		<?php endif; ?>

		<?php if ( $link_url ) : ?>
			<a
				class="event-item__link c-readmore"
				href="<?php echo esc_url( $link_url ); ?>"
				<?php if ( $link_target ) : ?>
					target="_blank"
					rel="noopener"
				<?php endif; ?>
			>
				<?php echo esc_html( $link_label ); ?>
				<span class="c-readmore__icon" aria-hidden="true">→</span>

				<?php if ( $link_target ) : ?>
					<span class="visually-hidden">
						<?php echo esc_html( inlife_t( '(otwiera w nowej karcie)' ) ); ?>
					</span>
				<?php endif; ?>
			</a>
		<?php endif; ?>

	</div>

</article>
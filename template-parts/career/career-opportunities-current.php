<?php
/**
 * Career opportunities – current offers and competitions.
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

$section_kicker = function_exists( 'get_field' )
	? get_field( 'career_opportunities_current_kicker', $post_id )
	: '';

$section_title = function_exists( 'get_field' )
	? get_field( 'career_opportunities_current_title', $post_id )
	: '';

$section_text = function_exists( 'get_field' )
	? get_field( 'career_opportunities_current_text', $post_id )
	: '';

$section_kicker = $section_kicker ?: inlife_t( 'Aktualne nabory' );
$section_title  = $section_title ?: inlife_t( 'Aktualne oferty i konkursy' );
$section_text   = $section_text ?: inlife_t( 'Poniżej znajdziesz bieżące konkursy na stanowiska naukowe oraz aktualne ogłoszenia o pracę.' );

$current_types = function_exists( 'inlife_get_career_current_types' )
	? inlife_get_career_current_types()
	: array();

$current_type_ids = array();

foreach ( $current_types as $current_type ) {
	$term = $current_type['term'] ?? null;

	if ( $term instanceof WP_Term ) {
		$current_type_ids[] = (int) $term->term_id;
	}
}

$current_type_ids = array_values(
	array_unique(
		array_filter( $current_type_ids )
	)
);

$query_args = function_exists( 'inlife_get_career_active_entries_query_args' )
	? inlife_get_career_active_entries_query_args( $current_type_ids, 10 )
	: array(
		'post_type'      => 'career_entry',
		'post__in'       => array( 0 ),
		'no_found_rows'  => true,
	);

$current_query = new WP_Query( $query_args );

$action_html = '';

if ( ! empty( $current_types ) ) {
	ob_start();
	?>
	<div
		class="c-pills"
		data-career-filters
		role="group"
		aria-label="<?php echo esc_attr( inlife_t( 'Filtrowanie aktualnych ofert' ) ); ?>"
	>
		<button
			type="button"
			class="c-pill is-active"
			data-career-filter="all"
			aria-pressed="true"
		>
			<?php echo esc_html( inlife_t( 'Wszystkie' ) ); ?>
		</button>

		<?php foreach ( $current_types as $current_type ) : ?>
			<?php
			$term = $current_type['term'] ?? null;

			if ( ! $term instanceof WP_Term ) {
				continue;
			}

			$filter_key = function_exists( 'inlife_get_career_type_filter_key' )
				? inlife_get_career_type_filter_key( $term )
				: '';
			?>

			<?php if ( '' === $filter_key ) : ?>
				<?php continue; ?>
			<?php endif; ?>

			<button
				type="button"
				class="c-pill"
				data-career-filter="<?php echo esc_attr( $filter_key ); ?>"
				aria-pressed="false"
			>
				<?php echo esc_html( $term->name ); ?>
			</button>
		<?php endforeach; ?>
	</div>
	<?php
	$action_html = (string) ob_get_clean();
}

get_template_part(
	'template-parts/components/section-header',
	null,
	array(
		'kicker'      => $section_kicker,
		'title'       => $section_title,
		'lead'        => $section_text,
		'action_html' => $action_html,
		'title_id'    => 'career-current-heading',
		'class'       => 'career-opportunities-current__header',
	)
);
?>

<div class="career-opportunities-current">
	<?php if ( $current_query->have_posts() ) : ?>
		<div class="career-archive-list" data-career-list>
			<?php
			while ( $current_query->have_posts() ) :
				$current_query->the_post();

				$entry_type = function_exists( 'inlife_get_career_entry_type_for_placement' )
					? inlife_get_career_entry_type_for_placement(
						(int) get_the_ID(),
						'current'
					)
					: null;

				$filter_key = (
					$entry_type instanceof WP_Term &&
					function_exists( 'inlife_get_career_type_filter_key' )
				)
					? inlife_get_career_type_filter_key( $entry_type )
					: 'other';
				?>
				<div
					class="career-archive-list__item"
					data-career-item
					data-career-type="<?php echo esc_attr( $filter_key ); ?>"
				>
					<?php get_template_part( 'template-parts/career/career-archive', 'card' ); ?>
				</div>
			<?php endwhile; ?>
		</div>

		<?php wp_reset_postdata(); ?>

		<div
			class="c-surface c-surface--panel career-opportunities-current__empty"
			data-career-empty
			hidden
		>
			<p class="career-opportunities-current__empty-text">
				<?php echo esc_html( inlife_t( 'Brak aktualnych ogłoszeń w wybranej kategorii.' ) ); ?>
			</p>
		</div>
		
		<p
			class="visually-hidden"
			role="status"
			aria-live="polite"
			aria-atomic="true"
			data-career-status
			data-career-status-label="<?php echo esc_attr( inlife_t( 'Liczba widocznych ofert i konkursów: %d.' ) ); ?>"
		></p>
	<?php else : ?>
		<div class="c-surface c-surface--panel career-opportunities-current__empty">
			<p class="career-opportunities-current__empty-text">
				<?php echo esc_html( inlife_t( 'Obecnie nie ma opublikowanych aktywnych ofert.' ) ); ?>
			</p>
		</div>
	<?php endif; ?>
</div>
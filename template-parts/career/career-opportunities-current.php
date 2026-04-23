<?php
/**
 * Career opportunities - current offers and competitions
 *
 * Frontend filtering, without page reload.
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

$type_map = [
	'scientific' => function_exists( 'inlife_get_career_type_slug' ) ? inlife_get_career_type_slug( 'scientific' ) : '',
	'jobs'       => function_exists( 'inlife_get_career_type_slug' ) ? inlife_get_career_type_slug( 'jobs' ) : '',
];

$type_slugs = array_values( array_filter( $type_map ) );

$query_args = [
	'post_type'           => 'career_entry',
	'post_status'         => 'publish',
	'posts_per_page'      => 10,
	'ignore_sticky_posts' => true,
	'no_found_rows'       => true,
];

if ( ! empty( $type_slugs ) ) {
	$query_args['tax_query'] = [
		[
			'taxonomy' => 'career_entry_type',
			'field'    => 'slug',
			'terms'    => $type_slugs,
		],
	];
}

$current_query = new WP_Query( $query_args );

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

	<button
		type="button"
		class="c-pill"
		data-career-filter="scientific"
		aria-pressed="false"
	>
		<?php echo esc_html( inlife_get_career_type_label( 'scientific' ) ); ?>
	</button>

	<button
		type="button"
		class="c-pill"
		data-career-filter="jobs"
		aria-pressed="false"
	>
		<?php echo esc_html( inlife_get_career_type_label( 'jobs' ) ); ?>
	</button>
</div>
<?php
$action_html = (string) ob_get_clean();

get_template_part(
	'template-parts/components/section-header',
	null,
	[
		'kicker'      => inlife_t( 'Aktualne nabory' ),
		'title'       => inlife_t( 'Aktualne oferty i konkursy' ),
		'lead'        => inlife_t( 'Poniżej znajdziesz bieżące konkursy na stanowiska naukowe oraz aktualne ogłoszenia o pracę.' ),
		'action_html' => $action_html,
		'title_id'    => 'career-current-heading',
		'class'       => 'career-opportunities-current__header',
	]
);
?>

<div class="career-opportunities-current">
	<?php if ( $current_query->have_posts() ) : ?>
		<div class="career-archive-list" data-career-list>
			<?php
			while ( $current_query->have_posts() ) :
				$current_query->the_post();

				$type_key = '';
				$terms    = get_the_terms( get_the_ID(), 'career_entry_type' );

				if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
					foreach ( $terms as $term ) {
						$resolved_key = function_exists( 'inlife_get_career_type_key_from_slug' )
							? inlife_get_career_type_key_from_slug( $term->slug )
							: null;

						if ( in_array( $resolved_key, [ 'scientific', 'jobs' ], true ) ) {
							$type_key = $resolved_key;
							break;
						}
					}
				}
				?>
				<div
					class="career-archive-list__item"
					data-career-item
					data-career-type="<?php echo esc_attr( $type_key ?: 'other' ); ?>"
				>
					<?php get_template_part( 'template-parts/career/career-archive', 'card' ); ?>
				</div>
			<?php endwhile; ?>
		</div>
		<?php wp_reset_postdata(); ?>

		<div class="c-surface c-surface--panel career-opportunities-current__empty" data-career-empty hidden>
			<p class="mb-0">
				<?php echo esc_html( inlife_t( 'Brak aktualnych ogłoszeń w wybranej kategorii.' ) ); ?>
			</p>
		</div>
	<?php else : ?>
		<div class="c-surface c-surface--panel career-opportunities-current__empty">
			<p class="mb-0">
				<?php echo esc_html( inlife_t( 'Obecnie nie ma opublikowanych aktywnych ofert.' ) ); ?>
			</p>
		</div>
	<?php endif; ?>
</div>
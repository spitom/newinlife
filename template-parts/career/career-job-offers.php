<?php
/**
 * Career job offers section.
 *
 * Landing preview of current Career opportunities.
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

$section_kicker = function_exists( 'get_field' )
	? get_field( 'career_job_offers_kicker', $post_id )
	: '';

$section_title = function_exists( 'get_field' )
	? get_field( 'career_job_offers_title', $post_id )
	: '';

$section_text = function_exists( 'get_field' )
	? get_field( 'career_job_offers_text', $post_id )
	: '';

$cta_label = function_exists( 'get_field' )
	? get_field( 'career_job_offers_cta_label', $post_id )
	: '';

$cta_url = function_exists( 'get_field' )
	? get_field( 'career_job_offers_cta_url', $post_id )
	: '';

$section_kicker = $section_kicker ?: inlife_t( 'Praca' );
$section_title  = $section_title ?: inlife_t( 'Aktualne oferty i konkursy' );
$section_text   = $section_text ?: inlife_t( 'Sprawdź najnowsze konkursy na stanowiska naukowe oraz aktualne ogłoszenia o pracę. Możesz od razu przejść do konkretnej oferty albo zobaczyć pełną sekcję ofert, wyników i archiwum.' );
$cta_label      = $cta_label ?: inlife_t( 'Zobacz wszystkie oferty i konkursy' );

$cta_url = $cta_url ?: (
	function_exists( 'inlife_get_career_opportunities_url' )
		? inlife_get_career_opportunities_url()
		: home_url( '/kariera/konkursy-i-oferty-pracy/' )
);

$preview_limit = 6;

$landing_types = function_exists( 'inlife_get_career_current_types' )
	? inlife_get_career_current_types( true )
	: array();

$landing_type_ids = array();

foreach ( $landing_types as $landing_type ) {
	$term = $landing_type['term'] ?? null;

	if ( $term instanceof WP_Term ) {
		$landing_type_ids[] = (int) $term->term_id;
	}
}

$landing_type_ids = array_values(
	array_unique(
		array_filter( $landing_type_ids )
	)
);

$query_args = function_exists( 'inlife_get_career_active_entries_query_args' )
	? inlife_get_career_active_entries_query_args(
		$landing_type_ids,
		$preview_limit
	)
	: array(
		'post_type'     => 'career_entry',
		'post__in'      => array( 0 ),
		'no_found_rows' => true,
	);

$career_query = new WP_Query( $query_args );

ob_start();
?>
<a class="c-readmore career-job-offers__all-link" href="<?php echo esc_url( $cta_url ); ?>">
	<span class="c-readmore__label">
		<?php echo esc_html( $cta_label ); ?>
	</span>
	<span class="c-readmore__icon" aria-hidden="true">→</span>
</a>
<?php
$action_html = (string) ob_get_clean();
?>

<div class="career-job-offers">
	<?php
	get_template_part(
		'template-parts/components/section-header',
		null,
		array(
			'kicker'      => $section_kicker,
			'title'       => $section_title,
			'lead'        => $section_text,
			'action_html' => $action_html,
			'title_id'    => 'career-job-offers-heading',
			'class'       => 'career-job-offers__header',
		)
	);
	?>

	<?php if ( $career_query->have_posts() ) : ?>
		<div class="career-job-offers__list career-archive-list">
			<?php
			while ( $career_query->have_posts() ) :
				$career_query->the_post();

				get_template_part(
					'template-parts/career/career-archive',
					'card',
					array(
						'heading_level' => 3,
					)
				);
			endwhile;
			?>
		</div>

		<?php wp_reset_postdata(); ?>
	<?php else : ?>
		<div class="career-job-offers__empty c-surface c-surface--panel">
			<p class="career-job-offers__empty-text mb-0">
				<?php
				echo esc_html(
					inlife_t(
						'Obecnie nie ma opublikowanych aktywnych ofert w tej sekcji.'
					)
				);
				?>
			</p>
		</div>
	<?php endif; ?>
</div>
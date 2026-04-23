<?php
/**
 * Career job offers section
 *
 * Landing preview of current opportunities based on real career entries.
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

$section_kicker = function_exists( 'get_field' ) ? get_field( 'career_job_offers_kicker', $post_id ) : '';
$section_title  = function_exists( 'get_field' ) ? get_field( 'career_job_offers_title', $post_id ) : '';
$section_text   = function_exists( 'get_field' ) ? get_field( 'career_job_offers_text', $post_id ) : '';
$cta_label      = function_exists( 'get_field' ) ? get_field( 'career_job_offers_cta_label', $post_id ) : '';
$cta_url        = function_exists( 'get_field' ) ? get_field( 'career_job_offers_cta_url', $post_id ) : '';

$section_kicker = $section_kicker ?: inlife_t( 'Praca' );
$section_title  = $section_title ?: inlife_t( 'Aktualne oferty i konkursy' );
$section_text   = $section_text ?: inlife_t( 'Sprawdź najnowsze konkursy na stanowiska naukowe oraz aktualne ogłoszenia o pracę. Możesz od razu przejść do konkretnej oferty albo zobaczyć pełną sekcję ofert, wyników i archiwum.' );
$cta_label      = $cta_label ?: inlife_t( 'Zobacz wszystkie oferty i konkursy' );
$cta_url        = $cta_url ?: home_url( '/kariera/konkursy-i-oferty-pracy/' );

$preview_limit = 6;

/**
 * Na tym etapie landing pokazuje wpisy z typów:
 * - scientific
 * - jobs
 *
 * To najbezpieczniejszy pierwszy krok bez przebudowy modelu danych.
 */
$type_slugs = array_filter(
	[
		function_exists( 'inlife_get_career_type_slug' ) ? inlife_get_career_type_slug( 'scientific' ) : '',
		function_exists( 'inlife_get_career_type_slug' ) ? inlife_get_career_type_slug( 'jobs' ) : '',
	]
);

$query_args = [
	'post_type'           => 'career_entry',
	'post_status'         => 'publish',
	'posts_per_page'      => $preview_limit,
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

$career_query = new WP_Query( $query_args );

ob_start();
?>
<a class="btn btn-outline-primary" href="<?php echo esc_url( $cta_url ); ?>">
	<?php echo esc_html( $cta_label ); ?>
</a>
<?php
$action_html = (string) ob_get_clean();
?>

<div class="career-job-offers">
	<?php
	get_template_part(
		'template-parts/components/section-header',
		null,
		[
			'kicker'      => $section_kicker,
			'title'       => $section_title,
			'lead'        => $section_text,
			'action_html' => $action_html,
			'title_id'    => 'career-job-offers-heading',
			'class'       => 'career-job-offers__header',
		]
	);
	?>

	<?php if ( $career_query->have_posts() ) : ?>
		<div class="career-job-offers__list career-archive-list">
			<?php
			while ( $career_query->have_posts() ) :
				$career_query->the_post();

				get_template_part( 'template-parts/career/career-archive', 'card' );
			endwhile;
			?>
		</div>
		<?php wp_reset_postdata(); ?>
	<?php else : ?>
		<div class="career-job-offers__empty c-surface c-surface--panel">
			<p class="career-job-offers__empty-text mb-0">
				<?php echo esc_html( inlife_t( 'Obecnie nie ma opublikowanych aktywnych ofert w tej sekcji.' ) ); ?>
			</p>
		</div>
	<?php endif; ?>
</div>
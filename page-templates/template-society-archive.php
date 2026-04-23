<?php
/**
 * Template Name: Society – Archive
 * Template Post Type: page
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

get_header();

$container = function_exists( 'inlife_container_class' ) ? inlife_container_class() : 'container';
$post_id   = get_the_ID();

$hero_kicker = function_exists( 'get_field' ) ? get_field( 'hero_kicker', $post_id ) : '';
$hero_title  = function_exists( 'get_field' ) ? get_field( 'hero_title', $post_id ) : '';
$hero_lead   = function_exists( 'get_field' ) ? get_field( 'hero_lead', $post_id ) : '';

$hero_kicker = $hero_kicker ?: inlife_t( 'Społeczeństwo' );
$hero_title  = $hero_title ?: inlife_t( 'Artykuły' );
$hero_lead   = $hero_lead ?: inlife_t( 'Artykuły, materiały wizualne i treści audio popularyzujące wiedzę i działania instytutu.' );

$current_format = isset( $_GET['format'] )
	? sanitize_title( wp_unslash( $_GET['format'] ) )
	: '';

$format_terms = function_exists( 'inlife_get_society_format_terms' )
	? inlife_get_society_format_terms()
	: [];

$query_args = function_exists( 'inlife_get_society_archive_query_args' )
	? inlife_get_society_archive_query_args( $current_format )
	: [];

$society_query = new WP_Query( $query_args );

$archive_url = get_permalink( $post_id );
?>

<main id="main-content" class="site-main site-main--society-archive">

	<section class="page-section page-section--society-archive-hero">
		<?php
		get_template_part(
			'template-parts/patterns/pattern-page-hero',
			null,
			[
				'kicker'      => $hero_kicker,
				'title'       => $hero_title,
				'lead'        => $hero_lead,
				'breadcrumbs' => true,
				'modifier'    => 'flush',
			]
		);
		?>
	</section>

	<?php
	get_template_part(
		'template-parts/society/society',
		'archive-filters',
		[
			'terms'          => $format_terms,
			'current_format' => $current_format,
			'base_url'       => $archive_url,
		]
	);
	?>

	<section class="page-section page-section--society-archive-listing">
		<div class="<?php echo esc_attr( $container ); ?>">

			<?php if ( $society_query->have_posts() ) : ?>

				<div class="c-card-grid c-card-grid--4">
					<?php while ( $society_query->have_posts() ) : $society_query->the_post(); ?>
						<?php
						$post_url = add_query_arg( 'from', 'society', get_permalink() );

						get_template_part(
							'template-parts/posts/posts',
							'card',
							[
								'post_id'       => get_the_ID(),
								'show_category' => false,
								'show_format'   => true,
								'custom_url'    => $post_url,
							]
						);
						?>
					<?php endwhile; ?>
				</div>

				<?php
				$pagination = paginate_links(
					[
						'total'     => $society_query->max_num_pages,
						'current'   => max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) ),
						'type'      => 'list',
						'prev_text' => '←',
						'next_text' => '→',
						'add_args'  => '' !== $current_format ? [ 'format' => $current_format ] : [],
					]
				);

				if ( $pagination ) :
					?>
					<nav class="society-archive-pagination" aria-label="<?php echo esc_attr( inlife_t( 'Paginacja materiałów społeczeństwo' ) ); ?>">
						<?php echo wp_kses_post( $pagination ); ?>
					</nav>
				<?php endif; ?>

			<?php else : ?>

				<div class="society-archive-empty c-surface c-surface--panel">
					<p><?php echo esc_html( inlife_t( 'Brak materiałów do wyświetlenia.' ) ); ?></p>
				</div>

			<?php endif; ?>

		</div>
	</section>

</main>

<?php
wp_reset_postdata();
get_footer();
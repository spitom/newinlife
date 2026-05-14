<?php
defined( 'ABSPATH' ) || exit;

get_header();

$container = function_exists( 'inlife_container_class' ) ? inlife_container_class() : 'container';
$term      = get_queried_object();

$term_name        = $term instanceof WP_Term ? $term->name : '';
$term_description = $term instanceof WP_Term ? term_description( $term, 'partner_region' ) : '';
?>

<main id="main-content" class="site-main site-main--partner-region">
	<section class="page-section page-section--partners-archive-hero">
		<?php
		$lead = $term_description
			? wp_strip_all_tags( $term_description )
			: sprintf(
				/* translators: %s region name */
				inlife_t( 'Zobacz partnerów współpracujących z Instytutem w regionie: %s.' ),
				$term_name
			);

		get_template_part(
			'template-parts/patterns/pattern-page-hero',
			null,
			[
				'kicker'      => inlife_t( 'Sieć współpracy' ),
				'title'       => sprintf(
					/* translators: %s region name */
					inlife_t( 'Partnerzy: %s' ),
					$term_name
				),
				'lead'        => $lead,
				'breadcrumbs' => true,
			]
		);
		?>
	</section>
	<section class="network-archive section-spacing">
		<div class="<?php echo esc_attr( $container ); ?>">
			<?php
			global $wp_query;

			get_template_part(
				'template-parts/network/network-archive-grid',
				null,
				[
					'query'     => $wp_query,
					'empty_msg' => inlife_t( 'Brak partnerów w tym regionie.' ),
				]
			);
			?>
		</div>
	</section>
</main>

<?php
wp_reset_postdata();
get_footer();
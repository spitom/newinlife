<?php
defined( 'ABSPATH' ) || exit;

get_header();

$container = function_exists( 'inlife_container_class' ) ? inlife_container_class() : 'container';
?>

<main id="main-content" class="site-main site-main--partners-archive">
	<section class="page-section page-section--partners-archive-hero">
		<?php
		get_template_part(
			'template-parts/patterns/pattern-page-hero',
			null,
			[
				'kicker'      => inlife_t( 'Sieć współpracy' ),
				'title'       => post_type_archive_title( '', false ),
				'lead'        => inlife_t( 'Poznaj instytucje i organizacje współpracujące z Instytutem w ramach międzynarodowej sieci partnerstw naukowych i instytucjonalnych.' ),
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
					'empty_msg' => inlife_t( 'Brak partnerów do wyświetlenia.' ),
				]
			);
			?>
		</div>
	</section>
</main>

<?php
wp_reset_postdata();
get_footer();
<?php
defined( 'ABSPATH' ) || exit;

get_header();

$container = function_exists( 'inlife_container_class' ) ? inlife_container_class() : 'container';
?>

<main id="main-content" class="site-main site-main--partners-archive">
	<section class="network-archive section-spacing">
		<div class="<?php echo esc_attr( $container ); ?>">
			<header class="network-archive__header">
				<p class="section-kicker">
					<?php echo esc_html( inlife_t( 'Sieć współpracy' ) ); ?>
				</p>

				<h1 class="network-archive__title">
					<?php post_type_archive_title(); ?>
				</h1>

				<div class="network-archive__lead">
					<p>
						<?php
						echo esc_html(
							inlife_t( 'Poznaj instytucje i organizacje współpracujące z Instytutem w ramach międzynarodowej sieci partnerstw naukowych i instytucjonalnych.' )
						);
						?>
					</p>
				</div>
			</header>

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
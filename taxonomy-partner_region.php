<?php
defined( 'ABSPATH' ) || exit;

get_header();

$container = function_exists( 'inlife_container_class' ) ? inlife_container_class() : 'container';
$term      = get_queried_object();

$term_name        = $term instanceof WP_Term ? $term->name : '';
$term_description = $term instanceof WP_Term ? term_description( $term, 'partner_region' ) : '';
?>

<main id="main-content" class="site-main site-main--partner-region">
	<section class="network-archive section-spacing">
		<div class="<?php echo esc_attr( $container ); ?>">
			<header class="network-archive__header">
				<p class="section-kicker">
					<?php echo esc_html( inlife_t( 'Sieć współpracy' ) ); ?>
				</p>

				<h1 class="network-archive__title">
					<?php
					echo esc_html(
						sprintf(
							/* translators: %s region name */
							inlife_t( 'Partnerzy: %s' ),
							$term_name
						)
					);
					?>
				</h1>

				<?php if ( $term_description ) : ?>
					<div class="network-archive__lead entry-content">
						<?php echo wp_kses_post( wpautop( $term_description ) ); ?>
					</div>
				<?php else : ?>
					<div class="network-archive__lead">
						<p>
							<?php
							echo esc_html(
								sprintf(
									/* translators: %s region name */
									inlife_t( 'Zobacz partnerów współpracujących z Instytutem w regionie: %s.' ),
									$term_name
								)
							);
							?>
						</p>
					</div>
				<?php endif; ?>

				<div class="network-archive__actions">
					<a class="btn btn-outline-primary" href="<?php echo esc_url( get_post_type_archive_link( 'partners' ) ); ?>">
						<?php echo esc_html( inlife_t( 'Zobacz wszystkich partnerów' ) ); ?>
					</a>
				</div>
			</header>

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
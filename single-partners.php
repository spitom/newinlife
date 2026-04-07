<?php
defined( 'ABSPATH' ) || exit;

get_header();

$container = function_exists( 'inlife_container_class' ) ? inlife_container_class() : 'container';

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();

		$partner = inlife_get_partner_single_data( get_the_ID() );
		?>
		<main id="main-content" class="site-main site-main--partner-single">
			<?php
			get_template_part(
				'template-parts/network/network-partner-header',
				null,
				[
					'container' => $container,
					'partner'   => $partner,
				]
			);
			?>

			<section class="network-partner section-spacing">
				<div class="<?php echo esc_attr( $container ); ?>">
					<div class="row g-4 g-xl-5">
						<div class="col-lg-7 col-xl-8">
							<?php
							get_template_part(
								'template-parts/network/network-partner-content',
								null,
								[
									'partner' => $partner,
								]
							);
							?>
						</div>

						<div class="col-lg-5 col-xl-4">
							<?php
							get_template_part(
								'template-parts/network/network-partner-aside',
								null,
								[
									'partner' => $partner,
								]
							);
							?>
						</div>
					</div>
				</div>
			</section>
		</main>
		<?php
	endwhile;
endif;

get_footer();
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
			<section class="page-section page-section--partner-hero">
				<?php
				$city     = $partner['city'] ?? '';
				$country  = $partner['country'] ?? '';
				$location = trim( implode( ', ', array_filter( [ $city, $country ] ) ) );

				get_template_part(
					'template-parts/patterns/pattern-page-hero',
					null,
					[
						'kicker'      => inlife_t( 'Partner sieci' ),
						'title'       => $partner['title'] ?? get_the_title(),
						'lead'        => $location,
						'breadcrumbs' => true,
					]
				);
				?>
			</section>
			<section class="network-partner section-spacing">
				<div class="<?php echo esc_attr( $container ); ?>">
					<div class="network-partner__layout">
						<div class="network-partner__main">
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

						<div class="network-partner__side">
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
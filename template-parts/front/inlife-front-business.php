<?php
defined( 'ABSPATH' ) || exit;

$business_page = get_page_by_path( 'biznes' );

if ( $business_page ) {
	$business_page_id = function_exists( 'pll_get_post' )
		? pll_get_post( $business_page->ID )
		: $business_page->ID;

	$business_url = get_permalink( $business_page_id );
} else {
	$business_url = home_url( '/biznes/' );
}

$business_links = [
	[
		'label' => inlife_t( 'Katalog usług i współpracy' ),
		'url'   => $business_url,
	],
	[
		'label' => inlife_t( 'Laboratoria' ),
		'url'   => home_url( '/laboratoria/' ),
	],
	[
		'label' => inlife_t( 'Technologie' ),
		'url'   => $business_url,
	],
];
?>

<section class="page-section page-section--front-business" aria-labelledby="front-business-heading">
	<div class="inlife-container">

		<div class="front-business">

			<div class="front-business__intro">
				<p class="front-business__kicker">
					<?php echo esc_html( inlife_t( 'Współpraca' ) ); ?>
				</p>

				<h2 id="front-business-heading" class="front-business__title">
					<?php echo esc_html( inlife_t( 'Nauka blisko praktyki' ) ); ?>
				</h2>

				<p class="front-business__text">
					<?php echo esc_html( inlife_t( 'Wspieramy partnerów w projektach badawczych, usługach laboratoryjnych i wdrażaniu innowacji.' ) ); ?>
				</p>

				<a class="c-readmore front-business__readmore" href="<?php echo esc_url( $business_url ); ?>">
					<?php echo esc_html( inlife_t( 'Zobacz możliwości współpracy' ) ); ?>
					<span class="c-readmore__icon" aria-hidden="true">→</span>
				</a>
			</div>

			<div class="front-business__grid c-link-grid c-link-grid--front-business">
				<?php foreach ( $business_links as $link ) : ?>
					<a class="front-business__panel c-link-grid__item" href="<?php echo esc_url( $link['url'] ); ?>">
						<span><?php echo esc_html( $link['label'] ); ?></span>
					</a>
				<?php endforeach; ?>
			</div>

		</div>

	</div>
</section>
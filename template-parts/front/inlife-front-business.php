<?php
defined( 'ABSPATH' ) || exit;

$business_url = get_permalink( get_page_by_path( 'biznes' ) );

if ( ! $business_url ) {
	$business_url = home_url( '/biznes/' );
}
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

				<a class="c-readmore" href="<?php echo esc_url( $business_url ); ?>">
					<?php echo esc_html( inlife_t( 'Zobacz możliwości współpracy' ) ); ?>
					<span class="c-readmore__icon">→</span>
				</a>
			</div>

			<div class="front-business__grid">

				<a class="front-business__panel front-business__panel--main" href="<?php echo esc_url( $business_url ); ?>">
					<span><?php echo esc_html( inlife_t( 'Katalog usług i współpracy' ) ); ?></span>
				</a>

				<a class="front-business__panel" href="#">
					<span><?php echo esc_html( inlife_t( 'Laboratoria' ) ); ?></span>
				</a>

				<a class="front-business__panel" href="#">
					<span><?php echo esc_html( inlife_t( 'Technologie' ) ); ?></span>
				</a>

			</div>

		</div>

	</div>
</section>
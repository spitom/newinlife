<?php
defined( 'ABSPATH' ) || exit;

$container = function_exists( 'inlife_container_class' ) ? inlife_container_class() : 'container';

$popielno_page = get_page_by_path( 'popielno' );

if ( $popielno_page ) {
	$popielno_page_id = function_exists( 'pll_get_post' )
		? pll_get_post( $popielno_page->ID )
		: $popielno_page->ID;

	$popielno_url = get_permalink( $popielno_page_id );
} else {
	$popielno_url = home_url( '/popielno/' );
}

$image_id = function_exists( 'get_field' )
	? (int) get_field( 'front_popielno_image', get_option( 'page_on_front' ) )
	: 0;
?>

<section id="popielno" class="front-section front-popielno" aria-labelledby="popielno-heading">
	<div class="<?php echo esc_attr( $container ); ?>">

		<div class="front-popielno__inner">

			<div class="front-popielno__content">
				<p class="front-popielno__kicker">
					<?php echo esc_html( inlife_t( 'Stacja badawcza' ) ); ?>
				</p>

				<h2 id="popielno-heading" class="front-popielno__title">
					<?php echo esc_html( inlife_t( 'Stacja Badawcza w Popielnie' ) ); ?>
				</h2>

				<p class="front-popielno__text">
					<?php echo esc_html( inlife_t( 'Unikalne miejsce badań terenowych, ochrony zasobów przyrodniczych i pracy naukowej prowadzonej blisko natury.' ) ); ?>
				</p>

				<a class="c-readmore front-popielno__readmore" href="<?php echo esc_url( $popielno_url ); ?>">
					<?php echo esc_html( inlife_t( 'Poznaj Popielno' ) ); ?>
					<span class="c-readmore__icon" aria-hidden="true">→</span>
				</a>
			</div>

			<div class="front-popielno__media">
				<?php if ( $image_id ) : ?>
					<?php
					echo wp_get_attachment_image(
						$image_id,
						'large',
						false,
						[
							'class'   => 'front-popielno__image',
							'loading' => 'lazy',
							'alt'     => '',
						]
					);
					?>
				<?php else : ?>
					<div class="front-popielno__placeholder" aria-hidden="true">
						<span><?php echo esc_html( inlife_t( 'Popielno' ) ); ?></span>
					</div>
				<?php endif; ?>
			</div>

		</div>

	</div>
</section>
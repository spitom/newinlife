<?php
/**
 * Front page — Popielno section.
 *
 * @package newinlife-child
 */

defined( 'ABSPATH' ) || exit;

$container = function_exists( 'inlife_container_class' )
	? inlife_container_class()
	: 'container';

$front_page_id = get_queried_object_id();

/*
 * Resolve the translated Popielno page.
 */
$popielno_page = get_page_by_path( 'popielno' );
$popielno_url  = home_url( '/popielno/' );

if ( $popielno_page instanceof WP_Post ) {
	$popielno_page_id = (int) $popielno_page->ID;

	if ( function_exists( 'pll_get_post' ) ) {
		$translated_popielno_page_id = (int) pll_get_post(
			$popielno_page_id
		);

		if ( $translated_popielno_page_id > 0 ) {
			$popielno_page_id = $translated_popielno_page_id;
		}
	}

	$resolved_popielno_url = get_permalink( $popielno_page_id );

	if ( $resolved_popielno_url ) {
		$popielno_url = $resolved_popielno_url;
	}
}

/*
 * Section content with safe fallbacks.
 */
$popielno_kicker = function_exists( 'get_field' )
	? trim(
		(string) get_field(
			'front_popielno_kicker',
			$front_page_id
		)
	)
	: '';

$popielno_title = function_exists( 'get_field' )
	? trim(
		(string) get_field(
			'front_popielno_title',
			$front_page_id
		)
	)
	: '';

$popielno_text = function_exists( 'get_field' )
	? trim(
		(string) get_field(
			'front_popielno_text',
			$front_page_id
		)
	)
	: '';

$popielno_cta = function_exists( 'get_field' )
	? get_field(
		'front_popielno_cta',
		$front_page_id
	)
	: null;

$popielno_image = function_exists( 'get_field' )
	? get_field(
		'front_popielno_image',
		$front_page_id
	)
	: null;

/*
 * Support both Image ID and Image Array return formats.
 */
$image_id = 0;

if ( is_array( $popielno_image ) ) {
	$image_id = isset( $popielno_image['ID'] )
		? (int) $popielno_image['ID']
		: 0;
} else {
	$image_id = (int) $popielno_image;
}

if ( '' === $popielno_kicker ) {
	$popielno_kicker = inlife_t( 'Stacja badawcza' );
}

if ( '' === $popielno_title ) {
	$popielno_title = inlife_t(
		'Stacja Badawcza w Popielnie'
	);
}

if ( '' === $popielno_text ) {
	$popielno_text = inlife_t(
		'Unikalne miejsce badań terenowych, ochrony zasobów przyrodniczych i pracy naukowej prowadzonej blisko natury.'
	);
}

if (
	! is_array( $popielno_cta ) ||
	empty( $popielno_cta['url'] )
) {
	$popielno_cta = [
		'url'    => $popielno_url,
		'title'  => inlife_t( 'Poznaj Popielno' ),
		'target' => '',
	];
}

$popielno_cta_url = (string) $popielno_cta['url'];

$popielno_cta_title = ! empty( $popielno_cta['title'] )
	? (string) $popielno_cta['title']
	: inlife_t( 'Poznaj Popielno' );

$popielno_cta_target = ! empty( $popielno_cta['target'] )
	? (string) $popielno_cta['target']
	: '';
?>

<section
	id="popielno"
	class="front-section front-popielno"
	aria-labelledby="popielno-heading"
>
	<div class="<?php echo esc_attr( $container ); ?>">

		<div class="front-popielno__inner">

			<div class="front-popielno__content">

				<p class="front-popielno__kicker">
					<?php echo esc_html( $popielno_kicker ); ?>
				</p>

				<h2
					id="popielno-heading"
					class="front-popielno__title"
				>
					<?php echo esc_html( $popielno_title ); ?>
				</h2>

				<p class="front-popielno__text">
					<?php echo esc_html( $popielno_text ); ?>
				</p>

				<a
					class="c-readmore c-readmore--light front-popielno__readmore"
					href="<?php echo esc_url( $popielno_cta_url ); ?>"
					<?php if ( '' !== $popielno_cta_target ) : ?>
						target="<?php echo esc_attr( $popielno_cta_target ); ?>"
					<?php endif; ?>
					<?php if ( '_blank' === $popielno_cta_target ) : ?>
						rel="noopener noreferrer"
					<?php endif; ?>
				>
					<?php echo esc_html( $popielno_cta_title ); ?>

					<span
						class="c-readmore__icon"
						aria-hidden="true"
					>
						→
					</span>
				</a>

			</div>

			<div class="front-popielno__media">

				<?php if ( $image_id > 0 ) : ?>

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

					<div
						class="front-popielno__placeholder"
						aria-hidden="true"
					>
						<span>
							<?php
							echo esc_html(
								inlife_t( 'Popielno' )
							);
							?>
						</span>
					</div>

				<?php endif; ?>

			</div>

		</div>

	</div>
</section>
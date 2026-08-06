<?php
/**
 * Front page — Business section.
 *
 * @package newinlife-child
 */

defined( 'ABSPATH' ) || exit;

$container = function_exists( 'inlife_container_class' )
	? inlife_container_class()
	: 'container';

$front_page_id = get_queried_object_id();

/*
 * Resolve the translated Business page.
 */
$business_page = get_page_by_path( 'biznes' );
$business_url  = home_url( '/biznes/' );

if ( $business_page instanceof WP_Post ) {
	$business_page_id = (int) $business_page->ID;

	if ( function_exists( 'pll_get_post' ) ) {
		$translated_business_page_id = (int) pll_get_post(
			$business_page_id
		);

		if ( $translated_business_page_id > 0 ) {
			$business_page_id = $translated_business_page_id;
		}
	}

	$resolved_business_url = get_permalink( $business_page_id );

	if ( $resolved_business_url ) {
		$business_url = $resolved_business_url;
	}
}

/*
 * Section content with safe fallbacks.
 */
$business_kicker = function_exists( 'get_field' )
	? trim(
		(string) get_field(
			'front_business_kicker',
			$front_page_id
		)
	)
	: '';

$business_title = function_exists( 'get_field' )
	? trim(
		(string) get_field(
			'front_business_title',
			$front_page_id
		)
	)
	: '';

$business_text = function_exists( 'get_field' )
	? trim(
		(string) get_field(
			'front_business_text',
			$front_page_id
		)
	)
	: '';

$business_cta = function_exists( 'get_field' )
	? get_field(
		'front_business_cta',
		$front_page_id
	)
	: null;

if ( '' === $business_kicker ) {
	$business_kicker = inlife_t( 'Współpraca' );
}

if ( '' === $business_title ) {
	$business_title = inlife_t( 'Nauka blisko praktyki' );
}

if ( '' === $business_text ) {
	$business_text = inlife_t(
		'Wspieramy partnerów w projektach badawczych, usługach laboratoryjnych i wdrażaniu innowacji.'
	);
}

if (
	! is_array( $business_cta ) ||
	empty( $business_cta['url'] )
) {
	$business_cta = [
		'url'    => $business_url,
		'title'  => inlife_t(
			'Zobacz możliwości współpracy'
		),
		'target' => '',
	];
}

$business_cta_url = (string) $business_cta['url'];

$business_cta_title = ! empty( $business_cta['title'] )
	? (string) $business_cta['title']
	: inlife_t( 'Zobacz możliwości współpracy' );

$business_cta_target = ! empty( $business_cta['target'] )
	? (string) $business_cta['target']
	: '';

/*
 * Cards from ACF.
 */
$business_links_raw = function_exists( 'get_field' )
	? get_field(
		'front_business_links',
		$front_page_id
	)
	: [];

$business_links = [];

if ( is_array( $business_links_raw ) ) {
	foreach ( $business_links_raw as $business_link_row ) {
		if ( ! is_array( $business_link_row ) ) {
			continue;
		}

		$link = $business_link_row['front_business_link']
			?? null;

		$title = trim(
			(string) (
				$business_link_row['front_business_link_title']
				?? ''
			)
		);

		$text = trim(
			(string) (
				$business_link_row['front_business_link_text']
				?? ''
			)
		);

		if (
			'' === $title ||
			! is_array( $link ) ||
			empty( $link['url'] )
		) {
			continue;
		}

		$business_links[] = [
			'title'  => $title,
			'text'   => $text,
			'url'    => (string) $link['url'],
			'target' => ! empty( $link['target'] )
				? (string) $link['target']
				: '',
		];
	}
}

/*
 * Fallback cards used until the repeater is completed.
 */
if ( empty( $business_links ) ) {
	$laboratories_url = get_post_type_archive_link(
		'laboratories'
	);

	if ( ! $laboratories_url ) {
		$laboratories_url = home_url( '/laboratoria/' );
	}

	$business_links = [
		[
			'title'  => inlife_t(
				'Katalog usług i współpracy'
			),
			'text'   => '',
			'url'    => $business_url,
			'target' => '',
		],
		[
			'title'  => inlife_t( 'Laboratoria' ),
			'text'   => '',
			'url'    => $laboratories_url,
			'target' => '',
		],
		[
			'title'  => inlife_t( 'Technologie' ),
			'text'   => '',
			'url'    => $business_url,
			'target' => '',
		],
	];
}
?>

<section
	class="page-section page-section--front-business"
	aria-labelledby="front-business-heading"
>
	<div class="<?php echo esc_attr( $container ); ?>">

		<div class="front-business">

			<div class="front-business__intro">

				<div class="front-business__content">
					<p class="front-business__kicker">
						<?php echo esc_html( $business_kicker ); ?>
					</p>

					<h2
						id="front-business-heading"
						class="front-business__title"
					>
						<?php echo esc_html( $business_title ); ?>
					</h2>

					<p class="front-business__text">
						<?php echo esc_html( $business_text ); ?>
					</p>
				</div>

				<a
					class="c-readmore front-business__readmore"
					href="<?php echo esc_url( $business_cta_url ); ?>"
					<?php if ( '' !== $business_cta_target ) : ?>
						target="<?php echo esc_attr( $business_cta_target ); ?>"
					<?php endif; ?>
					<?php if ( '_blank' === $business_cta_target ) : ?>
						rel="noopener noreferrer"
					<?php endif; ?>
				>
					<?php echo esc_html( $business_cta_title ); ?>

					<span
						class="c-readmore__icon"
						aria-hidden="true"
					>
						→
					</span>
				</a>

			</div>

			<div class="front-business__links">
				<?php foreach ( $business_links as $business_link ) : ?>
					<a
						class="front-business-link"
						href="<?php echo esc_url( $business_link['url'] ); ?>"
						<?php if ( '' !== $business_link['target'] ) : ?>
							target="<?php echo esc_attr( $business_link['target'] ); ?>"
						<?php endif; ?>
						<?php if ( '_blank' === $business_link['target'] ) : ?>
							rel="noopener noreferrer"
						<?php endif; ?>
					>
						<span class="front-business-link__label">
							<?php
							echo esc_html(
								$business_link['title']
							);
							?>
						</span>

						<?php if ( '' !== $business_link['text'] ) : ?>
							<span class="front-business-link__text">
								<?php
								echo esc_html(
									$business_link['text']
								);
								?>
							</span>
						<?php endif; ?>

						<span
							class="front-business-link__icon"
							aria-hidden="true"
						>
							→
						</span>
					</a>
				<?php endforeach; ?>
			</div>

		</div>

	</div>
</section>
<?php
/**
 * Business technologies
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

$post_id = $args['post_id'] ?? get_the_ID();

$section_kicker = inlife_get_acf_field(
	'business_technologies_kicker',
	$post_id,
	inlife_t( 'Nasze technologie' )
);

$section_title = inlife_get_acf_field(
	'business_technologies_title',
	$post_id,
	inlife_t( 'Patenty i rozwiązania gotowe do współpracy' )
);

$section_text = inlife_get_acf_field(
	'business_technologies_text',
	$post_id,
	inlife_t( 'Rozwijamy rozwiązania o potencjale wdrożeniowym i transferowym. Łączymy badania, doświadczenie eksperckie oraz zaplecze instytutowe, aby wspierać partnerów biznesowych w rozwoju nowych produktów i procesów.' )
);

// $section_cta = inlife_get_acf_field(
// 	'business_technologies_cta',
// 	$post_id,
// 	null
// );

/**
 * Fallback tiles.
 */
$tiles = [
	[
		'title'  => inlife_t( 'Patenty' ),
		'text'   => inlife_t( 'Rozwiązania o potencjale komercjalizacyjnym, gotowe do dalszych rozmów wdrożeniowych i rozwojowych.' ),
		'url'    => '#',
		'target' => '',
		'badge'  => inlife_t( 'Technologia' ),
		'meta'   => inlife_t( 'Poznaj portfolio' ),
	],
	[
		'title'  => inlife_t( 'Know-how' ),
		'text'   => inlife_t( 'Specjalistyczna wiedza i doświadczenie zespołów badawczych dostępne w modelu współpracy z partnerami zewnętrznymi.' ),
		'url'    => '#',
		'target' => '',
		'badge'  => inlife_t( 'Kompetencje' ),
		'meta'   => inlife_t( 'Sprawdź możliwości' ),
	],
	[
		'title'  => inlife_t( 'Rozwiązania dla rynku' ),
		'text'   => inlife_t( 'Wybrane technologie, procedury i modele współpracy wspierające wdrożenia oraz rozwój produktów.' ),
		'url'    => '#',
		'target' => '',
		'badge'  => inlife_t( 'Wdrożenia' ),
		'meta'   => inlife_t( 'Zobacz obszary' ),
	],
];

/**
 * ACF repeater.
 */
if ( function_exists( 'have_rows' ) && have_rows( 'business_technology_tiles', $post_id ) ) {
	$tiles = [];

	while ( have_rows( 'business_technology_tiles', $post_id ) ) {
		the_row();

		$title = get_sub_field( 'title' );
		$text  = get_sub_field( 'text' );
		$link  = get_sub_field( 'link' );
		$badge = get_sub_field( 'badge' );
		$meta  = get_sub_field( 'meta' );

		$url    = '#';
		$target = '';

		if ( is_array( $link ) && ! empty( $link['url'] ) ) {
			$url    = $link['url'];
			$target = ! empty( $link['target'] ) ? $link['target'] : '';
		} elseif ( is_string( $link ) && ! empty( $link ) ) {
			$url = $link;
		}

		$tiles[] = [
			'title'  => $title ?: '',
			'text'   => $text ?: '',
			'url'    => $url,
			'target' => $target,
			'badge'  => $badge ?: inlife_t( 'Technologia' ),
			'meta'   => $meta ?: inlife_t( 'Dowiedz się więcej' ),
		];
	}
}

?>

<div class="business-technologies">

	<?php
	if ( ! empty( $tiles ) ) :
		$main = $tiles[0] ?? null;
		$side = array_slice( $tiles, 1 );
		?>

		<div class="business-technologies__layout">

			<?php if ( $main ) : ?>
				<article class="business-tech-panel business-tech-panel--main">
					<a
						class="business-tech-panel__link"
						href="<?php echo esc_url( $main['url'] ); ?>"
						<?php echo ! empty( $main['target'] ) ? 'target="' . esc_attr( $main['target'] ) . '"' : ''; ?>
					>
						<div class="business-tech-panel__content">
							
							<div class="business-tech-panel__section">
								<?php if ( $section_kicker ) : ?>
									<p class="business-tech-panel__section-kicker">
										<?php echo esc_html( $section_kicker ); ?>
									</p>
								<?php endif; ?>

								<h2 class="business-tech-panel__section-title" id="business-technologies-heading">
									<?php echo esc_html( $section_title ); ?>
								</h2>

								<?php if ( $section_text ) : ?>
									<p class="business-tech-panel__section-lead">
										<?php echo esc_html( $section_text ); ?>
									</p>
								<?php endif; ?>
							</div>					

							<?php if ( ! empty( $main['meta'] ) ) : ?>
								<span class="business-tech-panel__meta">
									<?php echo esc_html( $main['meta'] ); ?>
								</span>
							<?php endif; ?>
						</div>
					</a>
				</article>
			<?php endif; ?>

			<?php if ( ! empty( $side ) ) : ?>
				<div class="business-tech-panel__aside">
					<?php foreach ( $side as $tile ) : ?>
						<article class="business-tech-panel business-tech-panel--side">
							<a
								class="business-tech-panel__link"
								href="<?php echo esc_url( $tile['url'] ); ?>"
								<?php echo ! empty( $tile['target'] ) ? 'target="' . esc_attr( $tile['target'] ) . '"' : ''; ?>
							>
								<?php if ( ! empty( $tile['badge'] ) ) : ?>
									<span class="business-tech-panel__badge">
										<?php echo esc_html( $tile['badge'] ); ?>
									</span>
								<?php endif; ?>

								<h3 class="business-tech-panel__title">
									<?php echo esc_html( $tile['title'] ); ?>
								</h3>

								<?php if ( ! empty( $tile['text'] ) ) : ?>
									<p class="business-tech-panel__text">
										<?php echo esc_html( $tile['text'] ); ?>
									</p>
								<?php endif; ?>

								<?php if ( ! empty( $tile['meta'] ) ) : ?>
									<span class="business-tech-panel__meta">
										<?php echo esc_html( $tile['meta'] ); ?>
									</span>
								<?php endif; ?>
							</a>
						</article>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

		</div>

	<?php endif; ?>
</div>
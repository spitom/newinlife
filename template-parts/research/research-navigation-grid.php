<?php
defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? [],
	[
		'section_id' => 'research-navigation',
		'title_id'   => 'research-navigation-heading',
		'kicker'     => '',
		'title'      => '',
		'lead'       => '',
		'items'      => [],
	]
);

$items = $args['items'];

/**
 * Fallback (jeśli brak ACF)
 */
if ( empty( $items ) ) {
	$base = trailingslashit( home_url() );

	$items = [
		[
			'title'       => inlife_t( 'Zespoły' ),
			'description' => inlife_t( 'Poznaj zespoły badawcze i ich profil.' ),
			'url'         => $base . 'zespoly/',
			'badge'       => '01',
		],
		[
			'title'       => inlife_t( 'Laboratoria' ),
			'description' => inlife_t( 'Zobacz zaplecze badawcze Instytutu.' ),
			'url'         => $base . 'laboratoria/',
			'badge'       => '02',
		],
		[
			'title'       => inlife_t( 'Obszary badań' ),
			'description' => inlife_t( 'Główne kierunki badawcze. Główne kierunki badawcze. Główne kierunki badawcze.' ),
			'url'         => $base . 'badania/obszary-badan/',
			'badge'       => '03',
		],
		[
			'title'       => inlife_t( 'Projekty' ),
			'description' => inlife_t( 'Projekty krajowe i międzynarodowe.' ),
			'url'         => $base . 'projekty/',
			'badge'       => '04',
		],
		[
			'title'       => inlife_t( 'Publikacje' ),
			'description' => inlife_t( 'Dorobek publikacyjny Instytutu.' ),
			'url'         => $base . 'badania/publikacje/',
			'badge'       => '05',
		],
	];
}
?>

<section id="<?php echo esc_attr( $args['section_id'] ); ?>" class="research-navigation-grid" aria-labelledby="<?php echo esc_attr( $args['title_id'] ); ?>">

	<div class="research-navigation-grid__list c-card-grid c-card-grid--4">

		<?php foreach ( $items as $index => $item ) : ?>

			<?php
			if ( empty( $item['title'] ) || empty( $item['url'] ) ) {
				continue;
			}

			$badge = $item['badge'] ?: str_pad( (string) ( $index + 1 ), 2, '0', STR_PAD_LEFT );
			?>

			<article class="research-navigation-grid__item">
				<a class="research-nav-card" href="<?php echo esc_url( $item['url'] ); ?>">

					<div class="research-nav-card__inner">

						<span class="research-nav-card__badge">
							<?php echo esc_html( $badge ); ?>
						</span>

						<h3 class="research-nav-card__title">
							<?php echo esc_html( $item['title'] ); ?>
						</h3>

						<?php if ( ! empty( $item['description'] ) ) : ?>
							<p class="research-nav-card__text">
								<?php echo esc_html( $item['description'] ); ?>
							</p>
						<?php endif; ?>

						<span class="research-nav-card__arrow" aria-hidden="true">→</span>

					</div>

				</a>
			</article>

		<?php endforeach; ?>

	</div>

</section>
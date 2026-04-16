<?php
defined( 'ABSPATH' ) || exit;

/**
 * Research navigation grid
 *
 * Args:
 * - section_id   (string)
 * - title_id     (string)
 * - kicker       (string)
 * - title        (string)
 * - lead         (string)
 * - action_html  (string)
 * - items        (array[]) optional
 *
 * Item structure:
 * [
 *   'title'       => '',
 *   'description' => '',
 *   'url'         => '',
 *   'badge'       => '',
 * ]
 */

$args = wp_parse_args(
	$args ?? [],
	[
		'section_id'  => 'research-navigation',
		'title_id'    => 'research-navigation-title',
		'kicker'      => inlife_t( 'Badania' ),
		'title'       => inlife_t( 'Poznaj strukturę działań badawczych' ),
		'lead'        => inlife_t( 'Przejdź do zespołów, laboratoriów, obszarów badań, projektów i publikacji Instytutu.' ),
		'action_html' => '',
		'items'       => [],
	]
);

$section_id  = sanitize_title( $args['section_id'] );
$title_id    = sanitize_html_class( $args['title_id'] );
$kicker      = $args['kicker'];
$title       = $args['title'];
$lead        = $args['lead'];
$action_html = $args['action_html'];
$items       = is_array( $args['items'] ) ? $args['items'] : [];

if ( empty( $items ) ) {
	$base_url = function_exists( 'pll_home_url' ) ? pll_home_url() : home_url( '/' );

	$items = [
		[
			'badge'       => '01',
			'title'       => inlife_t( 'Zespoły' ),
			'description' => inlife_t( 'Poznaj zespoły badawcze, ich profil naukowy, skład i powiązane obszary działalności.' ),
			'url'         => trailingslashit( $base_url ) . '/zespoly/',
		],
		[
			'badge'       => '02',
			'title'       => inlife_t( 'Laboratoria' ),
			'description' => inlife_t( 'Zobacz laboratoria, infrastrukturę badawczą i specjalistyczne zaplecze Instytutu.' ),
			'url'         => trailingslashit( $base_url ) . '/laboratoria/',
		],
		[
			'badge'       => '03',
			'title'       => inlife_t( 'Obszary badań' ),
			'description' => inlife_t( 'Sprawdź główne kierunki badawcze oraz tematy rozwijane w ramach działalności naukowej.' ),
			'url'         => trailingslashit( $base_url ) . 'badania/obszary-badan/',
		],
		[
			'badge'       => '04',
			'title'       => inlife_t( 'Projekty' ),
			'description' => inlife_t( 'Przejrzyj projekty krajowe i międzynarodowe realizowane przez Instytut i jego partnerów.' ),
			'url'         => trailingslashit( $base_url ) . '/projekty/',
		],
		[
			'badge'       => '05',
			'title'       => inlife_t( 'Publikacje' ),
			'description' => inlife_t( 'Przeglądaj dorobek publikacyjny Instytutu oraz powiązania publikacji z zespołami badawczymi.' ),
			'url'         => trailingslashit( $base_url ) . 'badania/publikacje/',
		],
		[
			'badge'       => '06',
			'title'       => inlife_t( 'Wydawnictwa' ),
			'description' => inlife_t( 'Przejdź do materiałów wydawniczych, opracowań i zasobów wspierających działalność Instytutu.' ),
			'url'         => trailingslashit( $base_url ) . 'badania/wydawnictwa/',
		],
		[
			'badge'       => '07',
			'title'       => inlife_t( 'Seminaria' ),
			'description' => inlife_t( 'Zobacz seminaria, spotkania naukowe i wydarzenia wspierające wymianę wiedzy.' ),
			'url'         => trailingslashit( $base_url ) . 'badania/seminaria/',
		],
	];
}
?>

<section
	id="<?php echo esc_attr( $section_id ); ?>"
	class="research-navigation-grid"
	aria-labelledby="<?php echo esc_attr( $title_id ); ?>"
>
	<!-- <?php
	get_template_part(
		'template-parts/components/section-header',
		null,
		[
			'kicker'      => $kicker,
			'title'       => $title,
			'lead'        => $lead,
			'action_html' => $action_html,
			'class'       => 'section-header--research-nav',
			'title_id'    => $title_id,
		]
	);
	?> -->

	<?php if ( ! empty( $items ) ) : ?>
		<div class="research-navigation-grid__list c-card-grid c-card-grid--4" role="list">
			<?php foreach ( $items as $item ) : ?>
				<?php
				$item = wp_parse_args(
					$item,
					[
						'badge'       => '',
						'title'       => '',
						'description' => '',
						'url'         => '',
					]
				);

				if ( '' === trim( $item['title'] ) || '' === trim( $item['url'] ) ) {
					continue;
				}
				?>
				<article class="research-navigation-grid__item" role="listitem">
					<a
						class="research-nav-card c-card c-card--nav"
						href="<?php echo esc_url( $item['url'] ); ?>"
					>
						<div class="research-nav-card__frame c-card__frame c-card__frame--cut-tl">
							<div class="research-nav-card__inner c-card__inner">
								<div class="research-nav-card__body c-card__body">
									<?php if ( $item['badge'] ) : ?>
										<div class="research-nav-card__meta">
											<span class="research-nav-card__badge">
												<?php echo esc_html( $item['badge'] ); ?>
											</span>
										</div>
									<?php endif; ?>

									<h3 class="research-nav-card__title c-card__title">
										<?php echo esc_html( $item['title'] ); ?>
									</h3>

									<?php if ( $item['description'] ) : ?>
										<p class="research-nav-card__text">
											<?php echo esc_html( $item['description'] ); ?>
										</p>
									<?php endif; ?>

									<span class="research-nav-card__readmore c-readmore">
										<?php echo esc_html( inlife_t( 'Zobacz więcej' ) ); ?>
										<span class="visually-hidden">
											<?php echo esc_html( $item['title'] ); ?>
										</span>
										<span class="c-readmore__icon" aria-hidden="true">→</span>
									</span>
								</div>
							</div>
						</div>
					</a>
				</article>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</section>
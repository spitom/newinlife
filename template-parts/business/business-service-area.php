<?php
/**
 * Business service area content.
 *
 * Static first version for layout validation.
 * Later this structure can be moved to ACF repeaters.
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

$area_sections = [
	[
		'number'   => '01',
		'title'    => 'Badania histologiczne',
		'lead'     => 'Usługi obejmujące przygotowanie, ocenę i ilościową analizę materiału tkankowego na potrzeby badań histologicznych, immunohistochemicznych i histopatologicznych.',
		'services' => [
			[
				'number' => '1.1',
				'title'  => 'Przygotowanie preparatów tkankowych',
				'text'   => 'Usługa obejmuje kompleksowe przygotowanie materiału tkankowego do badań histologicznych i immunohistochemicznych. Proces obejmuje utrwalanie, odwadnianie, zatapianie w parafinie lub w medium do zatapiania mrożeniowego, wykonywanie skrawków o odpowiedniej grubości, barwienie oraz montaż preparatów mikroskopowych. Przygotowane preparaty stanowią materiał do dalszych analiz mikroskopowych i oceny histopatologicznej.',
				'labs'   => [
					[
						'name'        => 'Laboratorium Analizy Komórek',
						'unit'        => 'pracownia histologii',
						'url'         => home_url( '/laboratoria/laboratorium-analizy-komorek/' ) . '#pracownia-histologii',
						'price_url'   => home_url( '/wp-content/uploads/cennik-test.pdf' ),
						'price_label' => inlife_t( 'Pobierz cennik' ),
					],
				],
			],
			[
				'number' => '1.2',
				'title'  => 'Ocena zmian morfologicznych tkanek',
				'text'   => 'Usługa obejmuje mikroskopową ocenę budowy tkanek w celu identyfikacji zmian wywołanych procesami chorobowymi, działaniem badanych substancji, biomateriałów lub wyrobów medycznych. Analiza umożliwia wykrycie m.in. zmian zapalnych, uszkodzeń komórkowych, martwicy, włóknienia oraz innych nieprawidłowości strukturalnych.',
				'labs'   => [
					[
						'name'        => 'Laboratorium Analizy Komórek',
						'unit'        => 'pracownia histologii',
						'url'         => home_url( '/laboratoria/laboratorium-analizy-komorek/' ) . '#pracownia-histologii',
						'price_url'   => '',
						'price_label' => inlife_t( 'Pobierz cennik' ),
					],
				],
			],
			[
				'number' => '1.3',
				'title'  => 'Ocena toksyczności narządowej',
				'text'   => 'Usługa obejmuje histopatologiczną ocenę narządów w celu identyfikacji zmian świadczących o działaniu toksycznym badanych substancji, biomateriałów lub wyrobów medycznych. Analiza pozwala określić stopień uszkodzenia narządów oraz ocenić bezpieczeństwo badanego produktu.',
				'labs'   => [
					[
						'name'        => 'Laboratorium Analizy Komórek',
						'unit'        => 'pracownia histologii',
						'url'         => home_url( '/laboratoria/laboratorium-analizy-komorek/' ) . '#pracownia-histologii',
						'price_url'   => '',
						'price_label' => inlife_t( 'Pobierz cennik' ),
					],
				],
			],
			[
				'number' => '1.4',
				'title'  => 'Analiza procesów zapalnych, martwicy i włóknienia',
				'text'   => 'Usługa obejmuje jakościową i półilościową ocenę procesów zapalnych oraz zmian martwiczych i włóknienia w tkankach. Analiza umożliwia ocenę odpowiedzi tkanek na badane substancje, biomateriały lub wyroby medyczne, a także monitorowanie procesów regeneracji i gojenia.',
				'labs'   => [
					[
						'name'        => 'Laboratorium Analizy Komórek',
						'unit'        => 'pracownia histologii',
						'url'         => home_url( '/laboratoria/laboratorium-analizy-komorek/' ) . '#pracownia-histologii',
						'price_url'   => '',
						'price_label' => inlife_t( 'Pobierz cennik' ),
					],
				],
			],
			[
				'number' => '1.5',
				'title'  => 'Ilościowa analiza zmian histologicznych',
				'text'   => 'Usługa obejmuje komputerową analizę obrazów mikroskopowych w celu obiektywnej oceny zakresu i nasilenia zmian histopatologicznych. Ocenie mogą podlegać m.in. powierzchnia zmian, liczba komórek, nacieki zapalne, stopień włóknienia, martwicy oraz inne parametry morfometryczne.',
				'labs'   => [
					[
						'name'        => 'Laboratorium Analizy Komórek',
						'unit'        => 'pracownia histologii',
						'url'         => home_url( '/laboratoria/laboratorium-analizy-komorek/' ) . '#pracownia-histologii',
						'price_url'   => '',
						'price_label' => inlife_t( 'Pobierz cennik' ),
					],
				],
			],
		],
	],
	[
		'number'   => '02',
		'title'    => 'Obrazowanie i analiza preparatów',
		'lead'     => '',
		'services' => [
			[
				'number' => '2.1',
				'title'  => 'Obrazowanie i analiza preparatów',
				'text'   => 'Usługa obejmuje obrazowanie preparatów histologicznych, immunohistochemicznych i immunofluorescencyjnych oraz ich jakościową i ilościową analizę z wykorzystaniem mikroskopii i specjalistycznego oprogramowania. Umożliwia ocenę zmian morfologicznych, ekspresji markerów oraz parametrów morfometrycznych.',
				'labs'   => [
					[
						'name'        => 'Laboratorium Analizy Komórek',
						'unit'        => 'pracownia obrazowania',
						'url'         => home_url( '/laboratoria/laboratorium-analizy-komorek/' ) . '#pracownia-obrazowania-i-analiz-komorek-i-tkanek',
						'price_url'   => '',
						'price_label' => inlife_t( 'Pobierz cennik' ),
					],
				],
			],
		],
	],
	[
		'number'   => '03',
		'title'    => 'Badania przy użyciu hodowli komórkowych',
		'lead'     => '',
		'services' => [
			[
				'number' => '3.1',
				'title'  => 'Badania przy użyciu hodowli komórkowych',
				'text'   => 'Usługa obejmuje prowadzenie badań z wykorzystaniem hodowli komórkowych in vitro w celu oceny aktywności biologicznej, skuteczności i bezpieczeństwa badanych substancji, biomateriałów oraz wyrobów medycznych. Badania umożliwiają analizę procesów komórkowych, takich jak proliferacja, migracja, apoptoza czy cytotoksyczność.',
				'labs'   => [
					[
						'name'        => 'Laboratorium Analizy Komórek',
						'unit'        => 'pracownia obrazowania',
						'url'         => home_url( '/laboratoria/laboratorium-analizy-komorek/' ) . '#pracownia-obrazowania-i-analiz-komorek-i-tkanek',
						'price_url'   => '',
						'price_label' => inlife_t( 'Pobierz cennik' ),
					],
				],
			],
		],
	],
	[
		'number'   => '04',
		'title'    => 'Profilowanie komórek',
		'lead'     => '',
		'services' => [
			[
				'number' => '4.1',
				'title'  => 'Profilowanie komórek',
				'text'   => 'Usługa obejmuje kompleksową charakterystykę populacji komórkowych z wykorzystaniem cytometrii przepływowej. Analiza umożliwia identyfikację typów komórek, ocenę ekspresji markerów powierzchniowych i wewnątrzkomórkowych oraz określenie zmian zachodzących w odpowiedzi na badane substancje lub warunki eksperymentalne.',
				'labs'   => [
					[
						'name'        => 'Laboratorium Analizy Komórek',
						'unit'        => 'pracownia obrazowania',
						'url'         => home_url( '/laboratoria/laboratorium-analizy-komorek/' ) . '#pracownia-obrazowania-i-analiz-komorek-i-tkanek',
						'price_url'   => '',
						'price_label' => inlife_t( 'Pobierz cennik' ),
					],
				],
			],
		],
	],
];

$sections_count      = count( $area_sections );
$sections_grid_class = '';

if ( $sections_count >= 2 ) {
	$sections_grid_class = ' c-card-grid--' . min( 4, $sections_count );
}
?>

<div class="business-service-area" id="business-service-area-content-heading">

	<nav
		class="business-service-area__nav c-card-grid<?php echo esc_attr( $sections_grid_class ); ?>"
		aria-label="<?php echo esc_attr( inlife_t( 'Nawigacja po usługach' ) ); ?>"
	>
		<?php foreach ( $area_sections as $index => $section ) : ?>
			<article class="business-service-card business-service-card--industry c-card c-card--nav">
				<div class="business-service-card__frame c-card__frame">
					<a
						class="business-service-card__link business-service-card__link--nav"
						href="#service-section-<?php echo esc_attr( $section['number'] ); ?>"
					>
						<div class="business-service-card__inner c-card__inner">
							<div class="business-service-card__body c-card__body">

								<div class="business-service-card__meta-row">
									<span class="business-service-card__index" aria-hidden="true">
										<?php echo esc_html( str_pad( (string) ( $index + 1 ), 2, '0', STR_PAD_LEFT ) ); ?>
									</span>
								</div>

								<h3 class="business-service-card__title c-card__title">
									<?php echo esc_html( $section['title'] ); ?>
								</h3>

								<span class="c-readmore c-readmore--light">
									<?php echo esc_html( inlife_t( 'Przejdź do sekcji' ) ); ?>
									<span class="visually-hidden">
										<?php echo esc_html( $section['title'] ); ?>
									</span>
									<span class="c-readmore__icon" aria-hidden="true">→</span>
								</span>

							</div>
						</div>
					</a>
				</div>
			</article>
		<?php endforeach; ?>
	</nav>

	<div class="business-service-area__main">
		<?php foreach ( $area_sections as $section ) : ?>
			<section
				id="service-section-<?php echo esc_attr( $section['number'] ); ?>"
				class="business-service-group"
				aria-labelledby="service-section-title-<?php echo esc_attr( $section['number'] ); ?>"
			>
				<header class="business-service-group__header">
					<span class="business-service-group__number" aria-hidden="true">
						<?php echo esc_html( $section['number'] ); ?>
					</span>

					<div class="business-service-group__heading">
						<h2
							id="service-section-title-<?php echo esc_attr( $section['number'] ); ?>"
							class="business-service-group__title"
						>
							<?php echo esc_html( $section['title'] ); ?>
						</h2>

						<?php if ( ! empty( $section['lead'] ) ) : ?>
							<p class="business-service-group__lead">
								<?php echo esc_html( $section['lead'] ); ?>
							</p>
						<?php endif; ?>
					</div>
				</header>

				<div class="business-service-group__list">
					<?php foreach ( $section['services'] as $service ) : ?>
						<article class="business-service-row">
							<div class="business-service-row__content">
								<div class="business-service-row__heading">
									<span class="business-service-row__number">
										<?php echo esc_html( $service['number'] ); ?>
									</span>

									<h3 class="business-service-row__title">
										<?php echo esc_html( $service['title'] ); ?>
									</h3>
								</div>

								<div class="business-service-row__text">
									<p>
										<?php echo esc_html( $service['text'] ); ?>
									</p>
								</div>
							</div>

							<?php if ( ! empty( $service['labs'] ) ) : ?>
								<div
									class="business-service-row__labs"
									aria-label="<?php echo esc_attr( inlife_t( 'Jednostki realizujące usługę' ) ); ?>"
								>
									<span class="business-service-row__labs-label">
										<?php echo esc_html( inlife_t( 'Realizuje' ) ); ?>
									</span>

									<?php foreach ( $service['labs'] as $lab ) : ?>
										<div class="business-service-lab-action">
											<a class="business-service-lab-link" href="<?php echo esc_url( $lab['url'] ); ?>">
												<span class="business-service-lab-link__name">
													<?php echo esc_html( $lab['name'] ); ?>
												</span>

												<?php if ( ! empty( $lab['unit'] ) ) : ?>
													<span class="business-service-lab-link__unit">
														<?php echo esc_html( $lab['unit'] ); ?>
													</span>
												<?php endif; ?>

												<span class="business-service-lab-link__icon" aria-hidden="true">→</span>
											</a>

											<?php if ( ! empty( $lab['price_url'] ) ) : ?>
												<a
													class="business-service-price-link btn btn-outline-primary"
													href="<?php echo esc_url( $lab['price_url'] ); ?>"
													target="_blank"
													rel="noopener"
												>
													<?php echo esc_html( $lab['price_label'] ?? inlife_t( 'Pobierz cennik' ) ); ?>
													<span class="visually-hidden">
														<?php echo esc_html( inlife_t( '(otwiera w nowej karcie)' ) ); ?>
													</span>
													<span aria-hidden="true">↓</span>
												</a>
											<?php endif; ?>
										</div>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>
						</article>
					<?php endforeach; ?>
				</div>
			</section>
		<?php endforeach; ?>
	</div>

</div>
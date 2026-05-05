<?php
defined( 'ABSPATH' ) || exit;

$container = function_exists( 'inlife_container_class' ) ? inlife_container_class() : 'container';

$teams_page = get_page_by_path( 'zespoly' );

if ( $teams_page ) {
	$teams_page_id = function_exists( 'pll_get_post' )
		? pll_get_post( $teams_page->ID )
		: $teams_page->ID;

	$teams_url = get_permalink( $teams_page_id );
} else {
	$teams_url = home_url( '/zespoly/' );
}

$business_page = get_page_by_path( 'biznes' );

if ( $business_page ) {
	$business_page_id = function_exists( 'pll_get_post' )
		? pll_get_post( $business_page->ID )
		: $business_page->ID;

	$business_url = get_permalink( $business_page_id );
} else {
	$business_url = home_url( '/biznes/' );
}

$area_cards = [
	[
		'url'     => add_query_arg( 'area', 'zywnosc', $teams_url ),
		'kicker'  => inlife_t( 'Żywność' ),
		'title'   => inlife_t( 'Bezpieczeństwo, jakość i wpływ żywności' ),
		'text'    => inlife_t( 'Badamy żywność, jej składniki i procesy, które wpływają na zdrowie oraz jakość życia.' ),
		'variant' => 'food',
	],
	[
		'url'     => add_query_arg( 'area', 'zwierzeta', $teams_url ),
		'kicker'  => inlife_t( 'Zwierzęta' ),
		'title'   => inlife_t( 'Rozród, biologia i dobrostan' ),
		'text'    => inlife_t( 'Rozwijamy wiedzę o mechanizmach rozrodu, zdrowiu i funkcjonowaniu organizmów zwierzęcych.' ),
		'variant' => 'animals',
	],
	[
		'url'     => add_query_arg( 'area', 'zdrowie', $teams_url ),
		'kicker'  => inlife_t( 'Zdrowie' ),
		'title'   => inlife_t( 'Mechanizmy zdrowia ludzi i zwierząt' ),
		'text'    => inlife_t( 'Łączymy badania podstawowe i aplikacyjne, aby lepiej rozumieć procesy wpływające na zdrowie.' ),
		'variant' => 'health',
	],
	// [
	// 	'url'     => $business_url,
	// 	'kicker'  => inlife_t( 'Współpraca' ),
	// 	'title'   => inlife_t( 'Nauka blisko praktyki' ),
	// 	'text'    => inlife_t( 'Wspieramy partnerów w projektach badawczych, usługach laboratoryjnych i wdrażaniu innowacji.' ),
	// 	'variant' => 'business',
	// 	'span'    => 'wide',
	// ],
];
?>

<section id="areas" class="page-section page-section--front-areas" aria-labelledby="front-areas-heading">
	<div class="<?php echo esc_attr( $container ); ?>">

		<?php
		get_template_part(
			'template-parts/components/section-header',
			null,
			[
				'kicker'   => inlife_t( 'Obszary działania' ),
				'title'    => inlife_t( 'Nauka dla ludzi, zwierząt i środowiska' ),
				'lead'     => inlife_t( 'Łączymy badania nad żywnością, zdrowiem i rozrodem z praktycznymi rozwiązaniami dla nauki, społeczeństwa i gospodarki.' ),
				'title_id' => 'front-areas-heading',
			]
		);
		?>

		<div class="front-areas-grid c-card-grid c-card-grid--front-areas">
			<?php foreach ( $area_cards as $card ) : ?>
				<?php
				$variant = ! empty( $card['variant'] ) ? sanitize_html_class( $card['variant'] ) : 'default';
				$span    = ! empty( $card['span'] ) ? sanitize_html_class( $card['span'] ) : '';

				$classes = [
					'front-area-card',
					'front-area-card--' . $variant,
				];

				if ( $span ) {
					$classes[] = 'front-area-card--' . $span;
				}
				?>

				<a class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>" href="<?php echo esc_url( $card['url'] ); ?>">
					<span class="front-area-card__kicker"><?php echo esc_html( $card['kicker'] ); ?></span>
					<h3 class="front-area-card__title"><?php echo esc_html( $card['title'] ); ?></h3>
					<p class="front-area-card__text"><?php echo esc_html( $card['text'] ); ?></p>
					<span class="front-area-card__arrow" aria-hidden="true">→</span>
				</a>
			<?php endforeach; ?>
		</div>

	</div>
</section>
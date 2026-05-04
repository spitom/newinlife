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
?>

<section id="areas" class="page-section page-section--front-areas" aria-labelledby="front-areas-heading">
	<div class="inlife-container">

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

		<div class="front-areas-grid">

			<a class="front-area-card front-area-card--food" href="<?php echo esc_url( add_query_arg( 'area', 'zywnosc', $teams_url ) ); ?>">
				<span class="front-area-card__kicker"><?php echo esc_html( inlife_t( 'Żywność' ) ); ?></span>
				<h3 class="front-area-card__title"><?php echo esc_html( inlife_t( 'Bezpieczeństwo, jakość i wpływ żywności' ) ); ?></h3>
				<p class="front-area-card__text"><?php echo esc_html( inlife_t( 'Badamy żywność, jej składniki i procesy, które wpływają na zdrowie oraz jakość życia.' ) ); ?></p>
				<span class="front-area-card__arrow" aria-hidden="true">→</span>
			</a>

			<a class="front-area-card front-area-card--animals" href="<?php echo esc_url( add_query_arg( 'area', 'zwierzeta', $teams_url ) ); ?>">
				<span class="front-area-card__kicker"><?php echo esc_html( inlife_t( 'Zwierzęta' ) ); ?></span>
				<h3 class="front-area-card__title"><?php echo esc_html( inlife_t( 'Rozród, biologia i dobrostan' ) ); ?></h3>
				<p class="front-area-card__text"><?php echo esc_html( inlife_t( 'Rozwijamy wiedzę o mechanizmach rozrodu, zdrowiu i funkcjonowaniu organizmów zwierzęcych.' ) ); ?></p>
				<span class="front-area-card__arrow" aria-hidden="true">→</span>
			</a>

			<a class="front-area-card front-area-card--health" href="<?php echo esc_url( add_query_arg( 'area', 'zdrowie', $teams_url ) ); ?>">
				<span class="front-area-card__kicker"><?php echo esc_html( inlife_t( 'Zdrowie' ) ); ?></span>
				<h3 class="front-area-card__title"><?php echo esc_html( inlife_t( 'Mechanizmy zdrowia ludzi i zwierząt' ) ); ?></h3>
				<p class="front-area-card__text"><?php echo esc_html( inlife_t( 'Łączymy badania podstawowe i aplikacyjne, aby lepiej rozumieć procesy wpływające na zdrowie.' ) ); ?></p>
				<span class="front-area-card__arrow" aria-hidden="true">→</span>
			</a>

			<a class="front-area-card front-area-card--wide front-area-card--business" href="<?php echo esc_url( $business_url ); ?>">
				<span class="front-area-card__kicker"><?php echo esc_html( inlife_t( 'Współpraca' ) ); ?></span>
				<h3 class="front-area-card__title"><?php echo esc_html( inlife_t( 'Nauka blisko praktyki' ) ); ?></h3>
				<p class="front-area-card__text"><?php echo esc_html( inlife_t( 'Wspieramy partnerów w projektach badawczych, usługach laboratoryjnych i wdrażaniu innowacji.' ) ); ?></p>
				<span class="front-area-card__arrow" aria-hidden="true">→</span>
			</a>

		</div>
	</div>
</section>
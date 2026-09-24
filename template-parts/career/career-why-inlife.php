<?php
/**
 * Career — Why InLife
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

$section_kicker = function_exists( 'get_field' )
	? get_field( 'career_why_kicker', $post_id )
	: '';

$section_title = function_exists( 'get_field' )
	? get_field( 'career_why_title', $post_id )
	: '';

$section_lead = function_exists( 'get_field' )
	? get_field( 'career_why_lead', $post_id )
	: '';

$section_kicker = $section_kicker ?: inlife_t( 'Dlaczego InLife?' );

$section_title = $section_title ?: inlife_t(
	'Dlaczego warto pracować w InLife?'
);

$section_lead = $section_lead ?: inlife_t(
	'Dobra nauka potrzebuje nie tylko ambitnych tematów, ale także ludzi, narzędzi i środowiska, które pozwala rozwijać pomysły. W InLife łączymy wysoką jakość badań, nowoczesną infrastrukturę, międzynarodową współpracę i profesjonalne wsparcie dla naukowców z jakością życia, jaką daje Olsztyn.'
);

$items = [
	[
		'title'     => inlife_t( 'Nauka na poziomie A+' ),
		'text'      => inlife_t(
			'InLife uzyskał najwyższą kategorię naukową A+ w obu ocenianych dyscyplinach: technologii żywności i żywienia oraz zootechnice i rybactwie. To najwyższa możliwa ocena jakości działalności naukowej w polskim systemie ewaluacji.'
		),
		'highlight' => '',
	],
	[
		'title'     => inlife_t( 'Infrastruktura do ambitnych badań' ),
		'text'      => inlife_t(
			'Pracujemy w nowoczesnej siedzibie wyposażonej w specjalistyczne laboratoria typu core facilities, zaawansowaną aparaturę badawczą oraz nowoczesną zwierzętarnię. Infrastruktura InLife została również wpisana na Polską Mapę Infrastruktury Badawczej, obejmującą zaplecze o strategicznym znaczeniu dla rozwoju nauki i innowacji.'
		),
		'highlight' => '',
	],
	[
		'title'     => inlife_t( 'Międzynarodowość i współpraca' ),
		'text'      => inlife_t(
			'Realizujemy badania w międzynarodowych konsorcjach, rozwijamy partnerstwa z zagranicznymi instytucjami i wspieramy mobilność naukowców. Współpracujemy także z przedsiębiorstwami, aby wiedza i wyniki badań mogły znajdować praktyczne zastosowanie.'
		),
		'highlight' => '',
	],
	[
		'title'     => inlife_t( 'Wsparcie dla Twoich badań' ),
		'text'      => inlife_t(
			'Od przygotowania projektu i pozyskania finansowania po jego realizację, rozliczenie i komunikację wyników – naukowcy mogą korzystać ze wsparcia wyspecjalizowanych zespołów InLife. Pomagamy również w obszarze zarządzania danymi badawczymi, własności intelektualnej i współpracy z przemysłem.'
		),
		'highlight' => '',
	],
	[
		'title'     => inlife_t( 'Nauka, która łączy ludzi' ),
		'text'      => inlife_t(
			'Chcemy, aby nauka wychodziła poza laboratoria. Organizujemy otwarte spotkania edukacyjne, seminaria i wydarzenia popularyzujące wiedzę, a inicjatywy pracownicze, takie jak Bike2InLife, pomagają budować społeczność również poza codzienną pracą.'
		),
		'highlight' => '',
	],
	[
		'title'     => inlife_t( 'Nauka i życie w równowadze' ),
		'text'      => inlife_t(
			'Wierzymy, że dobra praca powinna iść w parze z dobrą jakością życia. Siedziba InLife znajduje się kilka minut spacerem od jeziora Skanda, a miasto daje codzienny dostęp do jezior, lasów i tras rowerowych. To otoczenie, które sprzyja regeneracji, aktywności i zachowaniu równowagi między pracą a życiem poza nią.'
		),
		'highlight' => inlife_t(
			'Olsztyn sprzyja nauce. Kopernik sprawdził to przed nami.'
		),
	],
];

if (
	function_exists( 'have_rows' )
	&& have_rows( 'career_why_items', $post_id )
) {
	$items = [];

	while ( have_rows( 'career_why_items', $post_id ) ) {
		the_row();

		$item_title     = get_sub_field( 'title' );
		$item_text      = get_sub_field( 'text' );
		$item_highlight = get_sub_field( 'highlight' );

		if ( ! $item_title && ! $item_text && ! $item_highlight ) {
			continue;
		}

		$items[] = [
			'title'     => $item_title ?: '',
			'text'      => $item_text ?: '',
			'highlight' => $item_highlight ?: '',
		];
	}
}

$items = array_slice( $items, 0, 6 );
?>

<div class="career-why-inlife">

	<?php
	get_template_part(
		'template-parts/components/section-header',
		null,
		[
			'kicker'   => $section_kicker,
			'title'    => $section_title,
			'lead'     => $section_lead,
			'title_id' => 'career-why-inlife-heading',
			'class'    => 'career-why-inlife__header',
		]
	);
	?>

	<?php if ( ! empty( $items ) ) : ?>
		<div class="career-why-inlife__grid c-card-grid c-card-grid--3">

			<?php foreach ( $items as $item ) : ?>
				<article class="career-why-inlife__card">

					<?php if ( ! empty( $item['title'] ) ) : ?>
						<h3 class="career-why-inlife__title">
							<?php echo esc_html( $item['title'] ); ?>
						</h3>
					<?php endif; ?>

					<?php if ( ! empty( $item['highlight'] ) ) : ?>
						<p class="career-why-inlife__highlight">
							<?php echo esc_html( $item['highlight'] ); ?>
						</p>
					<?php endif; ?>

					<?php if ( ! empty( $item['text'] ) ) : ?>
						<div class="career-why-inlife__text">
							<?php echo wp_kses_post( wpautop( $item['text'] ) ); ?>
						</div>
					<?php endif; ?>

				</article>
			<?php endforeach; ?>

		</div>
	<?php endif; ?>

</div>
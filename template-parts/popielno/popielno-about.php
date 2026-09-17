<?php
/**
 * Popielno — About section.
 *
 * @package newinlife-child
 */

defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

$kicker = function_exists( 'inlife_get_acf_field' )
	? inlife_get_acf_field( 'popielno_about_kicker', $post_id, '' )
	: '';

$title = function_exists( 'inlife_get_acf_field' )
	? inlife_get_acf_field( 'popielno_about_title', $post_id, '' )
	: '';

$lead = function_exists( 'inlife_get_acf_field' )
	? inlife_get_acf_field( 'popielno_about_lead', $post_id, '' )
	: '';

$body = function_exists( 'inlife_get_acf_field' )
	? inlife_get_acf_field( 'popielno_about_body', $post_id, '' )
	: '';

if ( '' === trim( (string) $kicker ) ) {
	$kicker = inlife_t( 'O stacji' );
}

if ( '' === trim( (string) $title ) ) {
	$title = inlife_t( 'Nauka blisko natury' );
}

if ( '' === trim( (string) $lead ) ) {
	$lead = inlife_t(
		'Stacja Badawcza w Popielnie Polskiej Akademii Nauk to jedno z najbardziej niezwykłych miejsc w Polsce. Położona na malowniczym półwyspie, w otoczeniu jezior i Puszczy Piskiej, daje wyjątkową możliwość obserwowania przyrody z bliska — naprawdę z bliska.'
	);
}

if ( '' === trim( (string) $body ) ) {
	$body = inlife_t(
		'<p>To tutaj swobodnie żyją koniki polskie, jedyna rodzima rasa konia prymitywnego. Można spotkać je podczas spaceru po lesie lub zobaczyć w specjalnie przygotowanych zagrodach edukacyjnych.</p><p>Od dziesięcioleci w Stacji prowadzone są badania nad zachowaniem zwierząt oraz ochroną różnorodności biologicznej. Rozległe wybiegi i naturalne tereny umożliwiają bezpośrednią obserwację zwierząt w ich środowisku.</p><p>Na terenie Stacji znajduje się również niewielkie muzeum mieszczące się w XVIII-wiecznym spichlerzu. Prezentuje ono historię hodowli konika polskiego oraz działalność naukową prowadzoną w Popielnie i stanowi doskonałe wprowadzenie do poznania tego wyjątkowego miejsca.</p>'
	);
}
?>

<section
	id="o-stacji"
	class="page-section popielno-about"
	aria-labelledby="popielno-about-heading"
>
	<div class="<?php echo esc_attr( inlife_container_class( 'content' ) ); ?>">

		<?php
		get_template_part(
			'template-parts/components/section-header',
			null,
			[
				'kicker'   => $kicker,
				'title'    => $title,
				'lead'     => $lead,
				'title_id' => 'popielno-about-heading',
			]
		);
		?>

		<div class="popielno-about__body inlife-text c-editorial-content">
			<?php echo wp_kses_post( $body ); ?>
		</div>

	</div>
</section>

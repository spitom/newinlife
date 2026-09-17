<?php
/**
 * Template Name: Popielno
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

get_header();

$post_id = get_the_ID();

$hero_title    = get_the_title( $post_id );
$hero_image_id = get_post_thumbnail_id( $post_id );

$hero_lead = function_exists( 'inlife_get_acf_field' )
	? inlife_get_acf_field(
		'popielno_hero_lead',
		$post_id,
		inlife_t(
			'Unikalne miejsce badań terenowych, ochrony zasobów przyrodniczych i pracy naukowej prowadzonej blisko natury.'
		)
	)
	: inlife_t(
		'Unikalne miejsce badań terenowych, ochrony zasobów przyrodniczych i pracy naukowej prowadzonej blisko natury.'
	);

$logo_url = get_stylesheet_directory_uri() .
	'/assets/images/popielno-logo.png';

$hero_logo = sprintf(
	'<img class="popielno-hero__logo" src="%s" alt="">',
	esc_url( $logo_url )
);
?>

<main id="main-content" class="site-main site-main--popielno">

	<section class="page-section page-section--popielno-hero">
		<?php
		get_template_part(
			'template-parts/patterns/pattern-media-hero',
			null,
			[
				'kicker'       => '',
				'title'        => $hero_title,
				'lead'         => $hero_lead,
				'image_id'     => $hero_image_id,
				'breadcrumbs'  => true,
				'before_title' => $hero_logo,
				'variant'      => 'popielno',
				'title_id'     => 'popielno-hero-heading',
			]
		);
		?>
	</section>

    <?php
	get_template_part(
		'template-parts/popielno/popielno-nav'
	);
	?>

	<?php
	get_template_part(
		'template-parts/popielno/popielno-about'
	);
	?>

	<?php
	get_template_part(
		'template-parts/popielno/popielno-highlights'
	);
	?>

	<?php
	get_template_part(
		'template-parts/popielno/popielno-gallery'
	);
	?>

	<?php
	get_template_part(
		'template-parts/popielno/popielno-news'
	);
	?>

	<?php
	get_template_part(
		'template-parts/popielno/popielno-contact'
	);
	?>

</main>

<?php
get_footer();

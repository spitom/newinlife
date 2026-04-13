<?php
/**
 * Template Name: Biznes – Landing
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

get_header();

$container = function_exists( 'inlife_container_class' ) ? inlife_container_class() : 'container';

$post_id = get_the_ID();

if ( ! function_exists( 'inlife_get_acf_field' ) ) {
	function inlife_get_acf_field( $field_name, $post_id = 0, $default = null ) {
		if ( function_exists( 'get_field' ) ) {
			$value = get_field( $field_name, $post_id );

			if ( null !== $value && '' !== $value ) {
				return $value;
			}
		}

		return $default;
	}
}

$hero_kicker = inlife_get_acf_field(
	'business_hero_kicker',
	$post_id,
	'Biznes'
);

$hero_title = inlife_get_acf_field(
	'business_hero_title',
	$post_id,
	'Rozwiązania dla przemysłu i partnerów zewnętrznych'
);

$hero_lead = inlife_get_acf_field(
	'business_hero_lead',
	$post_id,
	'Wspieramy firmy i instytucje poprzez usługi laboratoryjne, transfer wiedzy, rozwój technologii oraz współpracę badawczo-rozwojową. Łączymy zaplecze naukowe z praktycznym podejściem do potrzeb biznesu.'
);

$primary_label = inlife_get_acf_field(
	'business_hero_cta_primary_label',
	$post_id,
	'Skontaktuj się z nami'
);

$primary_url = inlife_get_acf_field(
	'business_hero_cta_primary_url',
	$post_id,
	'#business-contact-heading'
);

$secondary_label = inlife_get_acf_field(
	'business_hero_cta_secondary_label',
	$post_id,
	'Zobacz usługi'
);

$secondary_url = inlife_get_acf_field(
	'business_hero_cta_secondary_url',
	$post_id,
	'#business-services-industries-heading'
);

ob_start();
?>
<a class="btn btn-primary" href="<?php echo esc_url( $primary_url ); ?>">
	<?php echo esc_html( $primary_label ); ?>
</a>

<a class="btn btn-outline-primary" href="<?php echo esc_url( $secondary_url ); ?>">
	<?php echo esc_html( $secondary_label ); ?>
</a>
<?php
$hero_actions = (string) ob_get_clean();
?>

<main id="main-content" class="site-main site-main--landing site-main--business">

	<section class="page-section page-section--business-hero" aria-labelledby="business-hero-heading">
		<?php
		get_template_part(
			'template-parts/patterns/pattern-page-hero',
			null,
			[
				'kicker'       => $hero_kicker,
				'title'        => $hero_title,
				'lead'         => $hero_lead,
				'breadcrumbs'  => true,
				'actions_html' => $hero_actions,
				'title_id' => 'business-hero-heading',
			]
		);
		?>
	</section>

	<section class="page-section page-section--business-services-industries" aria-labelledby="business-services-industries-heading">
		<div class="<?php echo esc_attr( $container ); ?>">
			<?php get_template_part( 'template-parts/business/business', 'services-industries' ); ?>
		</div>
	</section>

	<section class="page-section page-section--business-services-labs" aria-labelledby="business-services-labs-heading">
		<div class="<?php echo esc_attr( $container ); ?>">
			<?php get_template_part( 'template-parts/business/business', 'services-labs' ); ?>
		</div>
	</section>

	<section class="page-section page-section--business-technologies" aria-labelledby="business-technologies-heading">
		<div class="<?php echo esc_attr( $container ); ?>">
			<?php get_template_part( 'template-parts/business/business', 'technologies' ); ?>
		</div>
	</section>

	<section class="page-section page-section--business-cooperation" aria-labelledby="business-cooperation-heading">
		<div class="<?php echo esc_attr( $container ); ?>">
			<?php get_template_part( 'template-parts/business/business', 'cooperation' ); ?>
		</div>
	</section>

	<section class="page-section page-section--business-success-stories" aria-labelledby="business-success-stories-heading">
		<div class="<?php echo esc_attr( $container ); ?>">
			<?php get_template_part( 'template-parts/business/business', 'success-stories' ); ?>
		</div>
	</section>

	<section class="page-section page-section--business-contact" aria-labelledby="business-contact-heading">
		<div class="<?php echo esc_attr( $container ); ?>">
			<?php get_template_part( 'template-parts/business/business', 'contact' ); ?>
		</div>
	</section>

</main>

<?php
get_footer();
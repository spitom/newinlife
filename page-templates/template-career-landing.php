<?php
/**
 * Template Name: Kariera – Landing
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
	'career_hero_kicker',
	$post_id,
	'Kariera'
);

$hero_title = inlife_get_acf_field(
	'career_hero_title',
	$post_id,
	'Dołącz do zespołu InLife'
);

$hero_lead = inlife_get_acf_field(
	'career_hero_lead',
	$post_id,
	'Tworzymy środowisko pracy oparte na nauce, współpracy i rozwoju. Sprawdź aktualne możliwości dołączenia do Instytutu, poznaj nasze wartości oraz ścieżki rozwoju zawodowego.'
);

$primary_label = inlife_get_acf_field(
	'career_hero_cta_primary_label',
	$post_id,
	'Zobacz oferty pracy'
);

$primary_url = inlife_get_acf_field(
	'career_hero_cta_primary_url',
	$post_id,
	'#career-job-offers-heading'
);

$secondary_label = inlife_get_acf_field(
	'career_hero_cta_secondary_label',
	$post_id,
	'Poznaj nasze wartości'
);

$secondary_url = inlife_get_acf_field(
	'career_hero_cta_secondary_url',
	$post_id,
	'#career-values-heading'
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

<main id="main-content" class="site-main site-main--landing site-main--career">

	<section class="page-section page-section--career-hero" aria-labelledby="career-hero-heading">
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
			]
		);
		?>
	</section>

	<section class="page-section page-section--career-values" aria-labelledby="career-values-heading">
		<div class="<?php echo esc_attr( $container ); ?>">
			<?php get_template_part( 'template-parts/career/career', 'values' ); ?>
		</div>
	</section>

	<section class="page-section page-section--career-job-offers" aria-labelledby="career-job-offers-heading">
		<div class="<?php echo esc_attr( $container ); ?>">
			<?php get_template_part( 'template-parts/career/career', 'job-offers' ); ?>
		</div>
	</section>

	<section class="page-section page-section--career-doctoral-school" aria-labelledby="career-doctoral-school-heading">
		<div class="<?php echo esc_attr( $container ); ?>">
			<?php get_template_part( 'template-parts/career/career', 'doctoral-school' ); ?>
		</div>
	</section>

	<section class="page-section page-section--career-trainings" aria-labelledby="career-trainings-heading">
		<div class="<?php echo esc_attr( $container ); ?>">
			<?php get_template_part( 'template-parts/career/career', 'trainings' ); ?>
		</div>
	</section>

	<section class="page-section page-section--career-diversity" aria-labelledby="career-diversity-heading">
		<div class="<?php echo esc_attr( $container ); ?>">
			<?php get_template_part( 'template-parts/career/career', 'diversity' ); ?>
		</div>
	</section>

	<section class="page-section page-section--career-location-promo" aria-labelledby="career-location-promo-heading">
		<div class="<?php echo esc_attr( $container ); ?>">
			<?php get_template_part( 'template-parts/career/career', 'location-promo' ); ?>
		</div>
	</section>

	<section class="page-section page-section--career-hr-documents" aria-labelledby="career-hr-documents-heading">
		<div class="<?php echo esc_attr( $container ); ?>">
			<?php get_template_part( 'template-parts/career/career', 'hr-documents' ); ?>
		</div>
	</section>

	<section class="page-section page-section--career-onboarding" aria-labelledby="career-onboarding-heading">
		<div class="<?php echo esc_attr( $container ); ?>">
			<?php get_template_part( 'template-parts/career/career', 'onboarding' ); ?>
		</div>
	</section>

</main>

<?php
get_footer();
<?php
/**
 * Template Name: Kariera – Landing
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

get_header();

$container = function_exists( 'inlife_container_class' ) ? inlife_container_class() : 'container';
$post_id   = get_the_ID();

$hero_kicker = function_exists( 'get_field' ) ? get_field( 'career_hero_kicker', $post_id ) : '';
$hero_title  = function_exists( 'get_field' ) ? get_field( 'career_hero_title', $post_id ) : '';
$hero_lead   = function_exists( 'get_field' ) ? get_field( 'career_hero_lead', $post_id ) : '';

$primary_label = function_exists( 'get_field' ) ? get_field( 'career_hero_cta_primary_label', $post_id ) : '';
$primary_url   = function_exists( 'get_field' ) ? get_field( 'career_hero_cta_primary_url', $post_id ) : '';
$secondary_label = function_exists( 'get_field' ) ? get_field( 'career_hero_cta_secondary_label', $post_id ) : '';
$secondary_url   = function_exists( 'get_field' ) ? get_field( 'career_hero_cta_secondary_url', $post_id ) : '';

$hero_kicker = $hero_kicker ?: inlife_t( 'Kariera' );
$hero_title  = $hero_title ?: inlife_t( 'Dołącz do zespołu InLife' );
$hero_lead   = $hero_lead ?: inlife_t( 'Tworzymy środowisko pracy oparte na nauce, współpracy i rozwoju. Sprawdź aktualne możliwości dołączenia do Instytutu, poznaj nasze wartości oraz ścieżki rozwoju zawodowego.' );
$hero_image = get_field('career_hero_image');
$hero_image = function_exists( 'get_field' ) ? get_field( 'career_hero_image', $post_id ) : null;
$hero_image_id = 0;

if ( is_array( $hero_image ) && ! empty( $hero_image['ID'] ) ) {
	$hero_image_id = (int) $hero_image['ID'];
} elseif ( is_numeric( $hero_image ) ) {
	$hero_image_id = (int) $hero_image;
}

$primary_label = $primary_label ?: inlife_t( 'Zobacz aktualne oferty' );
$primary_url   = $primary_url ?: '#career-job-offers-heading';

$secondary_label = $secondary_label ?: inlife_t( 'Poznaj nasze wartości' );
$secondary_url   = $secondary_url ?: '#career-values-heading';

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
			'template-parts/patterns/pattern-media-hero',
			null,
			[
				'kicker'      => $hero_kicker ?? '',
				'title'       => $hero_title,
				'lead'        => $hero_lead,
				'image_id'    => $hero_image_id,
				'breadcrumbs' => true,

				'variant'     => 'career',
				'media_shape' => 'hex',

				// jeśli jest CTA:
				'actions_html' => $hero_actions ?? '',
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
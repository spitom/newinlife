<?php
/**
 * Template Name: Biznes – Obszar usług
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

get_header();

$container = function_exists( 'inlife_container_class' ) ? inlife_container_class() : 'container';
$post_id   = get_the_ID();

$hero_kicker = function_exists( 'inlife_get_acf_field' )
	? inlife_get_acf_field( 'business_area_hero_kicker', $post_id, inlife_t( 'Usługi dla biznesu' ) )
	: inlife_t( 'Usługi dla biznesu' );

$hero_title = function_exists( 'inlife_get_acf_field' )
	? inlife_get_acf_field( 'business_area_hero_title', $post_id, get_the_title( $post_id ) )
	: get_the_title( $post_id );

$hero_lead = function_exists( 'inlife_get_acf_field' )
	? inlife_get_acf_field(
		'business_area_hero_lead',
		$post_id,
		inlife_t( 'Poznaj zakres usług realizowanych przez laboratoria InLife dla partnerów zewnętrznych, firm i instytucji.' )
	)
	: inlife_t( 'Poznaj zakres usług realizowanych przez laboratoria InLife dla partnerów zewnętrznych, firm i instytucji.' );

$hero_image_id = has_post_thumbnail( $post_id )
	? get_post_thumbnail_id( $post_id )
	: 0;

$hero_variant = $hero_image_id ? 'graphic' : '';
?>

<main id="main-content" class="site-main site-main--landing site-main--business-service-area">

	<section class="page-section page-section--business-service-area-hero" aria-labelledby="business-service-area-heading">
		<?php
		get_template_part(
			'template-parts/patterns/pattern-media-hero',
			null,
			[
				'kicker'      => $hero_kicker,
				'title'       => $hero_title,
				'lead'        => $hero_lead,
				'image_id'    => $hero_image_id,
				'breadcrumbs' => true,
				'title_id'    => 'business-service-area-heading',
				'variant'     => $hero_variant,
			]
		);
		?>
	</section>

	<section class="page-section page-section--business-service-area-content" aria-labelledby="business-service-area-content-heading">
		<div class="<?php echo esc_attr( $container ); ?>">
			<?php get_template_part( 'template-parts/business/business', 'service-area' ); ?>
		</div>
	</section>

</main>

<?php
get_footer();
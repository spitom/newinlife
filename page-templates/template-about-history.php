<?php
/**
 * Template Name: O nas – Historia
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

get_header();

$container = function_exists( 'inlife_container_class' ) ? inlife_container_class() : 'container';
$post_id   = get_the_ID();

$hero_kicker = inlife_get_acf_field( 'history_hero_kicker', $post_id, inlife_t( 'Dziedzictwo i rozwój' ) );
$hero_title  = inlife_get_acf_field( 'history_hero_title', $post_id, get_the_title() );
$hero_lead   = inlife_get_acf_field(
	'history_hero_lead',
	$post_id,
	inlife_t( 'Poznaj najważniejsze etapy rozwoju Instytutu – od początków działalności po współczesną, interdyscyplinarną jednostkę badawczą.' )
);
?>

<main id="main-content" class="site-main site-main--about site-main--about-history-landing">

	<section class="page-section page-section--about-history-hero">
		<?php
		get_template_part(
			'template-parts/patterns/pattern-page-hero',
			null,
			[
				'kicker'      => $hero_kicker,
				'title'       => $hero_title,
				'lead'        => $hero_lead,
				'breadcrumbs' => true,
				'title_id'    => 'about-history-hero-heading',
			]
		);
		?>
	</section>

	<section class="page-section page-section--about-history-landing" aria-labelledby="about-history-landing-heading">
		<div class="<?php echo esc_attr( $container ); ?>">
			<?php get_template_part( 'template-parts/about/about', 'history-landing' ); ?>
		</div>
	</section>

</main>

<?php
get_footer();
<?php
/**
 * Template Name: O nas – Struktura
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

get_header();

$container = function_exists( 'inlife_container_class' ) ? inlife_container_class() : 'container';
$post_id   = get_the_ID();

$hero_kicker = inlife_get_acf_field( 'structure_hero_kicker', $post_id, inlife_t( 'Poznaj Instytut' ) );
$hero_title  = inlife_get_acf_field( 'structure_hero_title', $post_id, get_the_title() );
$hero_lead   = inlife_get_acf_field(
	'structure_hero_lead',
	$post_id,
	inlife_t( 'Poznaj strukturę organizacyjną Instytutu, najważniejsze obszary działalności oraz jednostki wspierające pracę naukową i administracyjną.' )
);
?>

<main id="main-content" class="site-main site-main--about site-main--about-structure">

	<section class="page-section page-section--about-structure-hero">
		<?php
		get_template_part(
			'template-parts/patterns/pattern-page-hero',
			null,
			[
				'kicker'      => $hero_kicker,
				'title'       => $hero_title,
				'lead'        => $hero_lead,
				'breadcrumbs' => true,
				'title_id'    => 'about-structure-hero-heading',
			]
		);
		?>
	</section>

	<section class="page-section page-section--about-structure-landing" aria-labelledby="about-structure-landing-heading">
		<div class="<?php echo esc_attr( $container ); ?>">
			<?php get_template_part( 'template-parts/about/about', 'structure-landing' ); ?>
		</div>
	</section>

</main>

<?php
get_footer();
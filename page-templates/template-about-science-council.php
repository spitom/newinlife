<?php
/**
 * Template Name: O nas – Rada Naukowa
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

get_header();

$container = function_exists( 'inlife_container_class' ) ? inlife_container_class() : 'container';
$post_id   = get_the_ID();

$hero_kicker = inlife_get_acf_field( 'science_council_hero_kicker', $post_id, inlife_t( 'Organ naukowy' ) );
$hero_title  = inlife_get_acf_field( 'science_council_hero_title', $post_id, get_the_title() );
$hero_lead   = inlife_get_acf_field(
	'science_council_hero_lead',
	$post_id,
	inlife_t( 'Rada Naukowa jest organem opiniodawczym, doradczym i nadzorczym wspierającym działalność naukową Instytutu.' )
);
?>

<main id="main-content" class="site-main site-main--about site-main--about-science-council-landing">

	<section class="page-section page-section--about-science-council-hero">
		<?php
		get_template_part(
			'template-parts/patterns/pattern-page-hero',
			null,
			[
				'kicker'      => $hero_kicker,
				'title'       => $hero_title,
				'lead'        => $hero_lead,
				'breadcrumbs' => true,
				'title_id'    => 'about-science-council-hero-heading',
			]
		);
		?>
	</section>

	<section class="page-section page-section--about-science-council-landing" aria-labelledby="about-science-council-landing-heading">
		<div class="<?php echo esc_attr( $container ); ?>">
			<?php get_template_part( 'template-parts/about/about', 'science-council-landing' ); ?>
		</div>
	</section>

</main>

<?php
get_footer();
<?php
/**
 * Template Name: Badania – Overview
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

get_header();

$container = function_exists( 'inlife_container_class' ) ? inlife_container_class() : 'container';

$post_id = get_the_ID();

/**
 * HERO (ACF + fallback)
 */
$hero_kicker = inlife_get_acf_field(
	'research_hero_kicker',
	$post_id,
	inlife_t( 'Badania' )
);

$hero_title = inlife_get_acf_field(
	'research_hero_title',
	$post_id,
	get_the_title()
);

$hero_lead = inlife_get_acf_field(
	'research_hero_lead',
	$post_id,
	inlife_t( 'Poznaj główne obszary działalności naukowej Instytutu: zespoły badawcze, laboratoria, projekty, publikacje oraz pozostałe zasoby wspierające rozwój badań.' )
);

/**
 * NAV ITEMS (ACF repeater)
 */
$nav_items = [];

if ( function_exists( 'have_rows' ) && have_rows( 'research_navigation_items', $post_id ) ) {
	while ( have_rows( 'research_navigation_items', $post_id ) ) {
		the_row();

		$title = get_sub_field( 'title' );
		$text  = get_sub_field( 'description' );
		$link  = get_sub_field( 'link' );
		$badge = get_sub_field( 'badge' );

		$url    = '';
		$target = '';

		if ( is_array( $link ) && ! empty( $link['url'] ) ) {
			$url    = $link['url'];
			$target = $link['target'] ?? '';
		} elseif ( is_string( $link ) && ! empty( $link ) ) {
			$url = $link;
		}

		if ( $title && $url ) {
			$nav_items[] = [
				'title'       => $title,
				'description' => $text,
				'url'         => $url,
				'target'      => $target,
				'badge'       => $badge,
			];
		}
	}
}
?>

<main id="main-content" class="site-main site-main--landing site-main--research-overview">

	<section class="page-section page-section--research-hero">
		<?php
		get_template_part(
			'template-parts/patterns/pattern-page-hero',
			null,
			[
				'kicker'      => $hero_kicker,
				'title'       => $hero_title,
				'lead'        => $hero_lead,
				'breadcrumbs' => true,
				'title_id'    => 'research-hero-heading',
			]
		);
		?>
	</section>

	<section class="page-section page-section--research-nav">
		<div class="<?php echo esc_attr( $container ); ?>">

			<?php
			get_template_part(
				'template-parts/research/research',
				'navigation-grid',
				[
					'section_id' => 'research-navigation',
					'title_id'   => 'research-navigation-heading',
					'items'      => $nav_items,
				]
			);
			?>

		</div>
	</section>

</main>

<?php
get_footer();
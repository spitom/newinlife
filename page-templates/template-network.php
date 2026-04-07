<?php
/**
 * Template Name: Network
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

get_header();

$container      = function_exists( 'inlife_container_class' ) ? inlife_container_class() : 'container';
$partners_query = inlife_get_network_partners_query();
$region_terms   = inlife_get_partner_region_terms();
$map_data       = inlife_get_network_map_data( $partners_query );
?>

<main id="main-content" class="site-main site-main--network">
	<?php
	get_template_part(
		'template-parts/network/network-hero',
		null,
		[
			'container' => $container,
		]
	);

	get_template_part(
		'template-parts/network/network-filters',
		null,
		[
			'container'    => $container,
			'region_terms' => $region_terms,
		]
	);

	get_template_part(
		'template-parts/network/network-map',
		null,
		[
			'container' => $container,
			'map_data'  => $map_data,
		]
	);

	get_template_part(
		'template-parts/network/network-partners-grid',
		null,
		[
			'container'      => $container,
			'partners_query' => $partners_query,
		]
	);
	?>
</main>

<?php
wp_reset_postdata();
get_footer();
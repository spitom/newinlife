<?php
defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? [],
	[
		'container'      => 'container',
		'partners_query' => null,
	]
);

$container      = $args['container'];
$partners_query = $args['partners_query'];
?>

<section class="network-partners section-spacing" aria-labelledby="network-partners-heading">
	<div class="<?php echo esc_attr( $container ); ?>">
		
		<?php
		get_template_part(
			'template-parts/components/section-header',
			null,
			[
				'title'    => inlife_t( 'Lista partnerów' ),
				'title_id' => 'network-partners-heading',
				'class'    => 'network-partners__header',
			]
		);
		?>
	

		<?php
		get_template_part(
			'template-parts/network/network-archive-grid',
			null,
			[
				'query'     => $partners_query,
				'empty_msg' => inlife_t( 'Brak partnerów do wyświetlenia.' ),
			]
		);
		?>
	</div>
</section>
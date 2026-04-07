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
		<div class="network-partners__header">
			<h2 id="network-partners-heading" class="section-title">
				<?php echo esc_html( inlife_t( 'Lista partnerów' ) ); ?>
			</h2>
		</div>

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
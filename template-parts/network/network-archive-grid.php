<?php
defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? [],
	[
		'query'     => null,
		'empty_msg' => inlife_t( 'Brak partnerów do wyświetlenia.' ),
	]
);

$query     = $args['query'];
$empty_msg = $args['empty_msg'];
?>

<?php if ( $query instanceof WP_Query && $query->have_posts() ) : ?>
	<div class="network-grid">
		<?php
		while ( $query->have_posts() ) :
			$query->the_post();

			get_template_part(
				'template-parts/network/network-partner-card',
				null,
				[
					'post_id' => get_the_ID(),
				]
			);
		endwhile;
		?>
	</div>
<?php else : ?>
	<p class="network-empty">
		<?php echo esc_html( $empty_msg ); ?>
	</p>
<?php endif; ?>
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
	<div
		class="c-card-grid c-card-grid--4 network-grid"
		id="network-partners-list"
	>
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
		<p
		class="network-empty"
		data-network-empty
		hidden
	>
		<?php echo esc_html( inlife_t( 'Brak partnerów w wybranym regionie.' ) ); ?>
	</p>
	<p
		class="visually-hidden"
		role="status"
		aria-live="polite"
		aria-atomic="true"
		data-network-status
		data-network-status-label="<?php echo esc_attr( inlife_t( 'Liczba widocznych partnerów: %d.' ) ); ?>"
	></p>
<?php else : ?>
	<p class="network-empty">
		<?php echo esc_html( $empty_msg ); ?>
	</p>
<?php endif; ?>
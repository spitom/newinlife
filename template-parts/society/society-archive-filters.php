<?php
/**
 * Society archive filters
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

$terms          = $args['terms'] ?? [];
$current_format = $args['current_format'] ?? '';
$base_url       = $args['base_url'] ?? '';

if ( empty( $terms ) || ! $base_url ) {
	return;
}
?>

<nav class="society-archive-nav" aria-label="<?php echo esc_attr( inlife_t( 'Filtruj materiały społeczeństwo' ) ); ?>">
	<div class="<?php echo esc_attr( inlife_container_class() ); ?>">

		<ul class="c-pills">
			<li>
				<a
					class="c-pill<?php echo '' === $current_format ? ' is-active' : ''; ?>"
					href="<?php echo esc_url( $base_url ); ?>"
					<?php echo '' === $current_format ? 'aria-current="page"' : ''; ?>
				>
					<?php echo esc_html( inlife_t( 'Wszystkie' ) ); ?>
				</a>
			</li>

			<?php foreach ( $terms as $term ) : ?>
				<li>
					<a
						class="c-pill<?php echo $current_format === $term->slug ? ' is-active' : ''; ?>"
						href="<?php echo esc_url( add_query_arg( 'format', $term->slug, $base_url ) ); ?>"
						<?php echo $current_format === $term->slug ? 'aria-current="page"' : ''; ?>
					>
						<?php echo esc_html( $term->name ); ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>

	</div>
</nav>
<?php
defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? [],
	[
		'items'     => [],
		'class'     => '',
		'show_home' => true,
	]
);

$items = inlife_get_breadcrumb_items(
	[
		'items'     => $args['items'],
		'show_home' => (bool) $args['show_home'],
	]
);

if ( empty( $items ) ) {
	return;
}

$component_classes = trim( 'c-breadcrumbs ' . $args['class'] );
?>

<nav class="<?php echo esc_attr( $component_classes ); ?>" aria-label="<?php echo esc_attr( inlife_t( 'Okruszki' ) ); ?>">
	<ol class="c-breadcrumbs__list">
		<?php foreach ( $items as $item ) : ?>
			<li class="c-breadcrumbs__item<?php echo ! empty( $item['current'] ) ? ' is-current' : ''; ?>">
				<?php if ( ! empty( $item['current'] ) ) : ?>
					<span class="c-breadcrumbs__current" aria-current="page">
						<?php echo esc_html( $item['label'] ); ?>
					</span>
				<?php elseif ( ! empty( $item['url'] ) ) : ?>
					<a class="c-breadcrumbs__link" href="<?php echo esc_url( $item['url'] ); ?>">
						<?php echo esc_html( $item['label'] ); ?>
					</a>
				<?php else : ?>
					<span class="c-breadcrumbs__text">
						<?php echo esc_html( $item['label'] ); ?>
					</span>
				<?php endif; ?>
			</li>
		<?php endforeach; ?>
	</ol>
</nav>
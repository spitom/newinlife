<?php
/**
 * Local navigation for the Popielno landing page.
 *
 * @package newinlife-child
 */

defined( 'ABSPATH' ) || exit;

$items = [
	[
		'label'  => inlife_t( 'O stacji' ),
		'anchor' => 'o-stacji',
	],
	[
		'label'  => inlife_t( 'Badania i przyroda' ),
		'anchor' => 'badania-przyroda',
	],
	[
		'label'  => inlife_t( 'Galeria' ),
		'anchor' => 'galeria',
	],
	[
		'label'  => inlife_t( 'Aktualności' ),
		'anchor' => 'aktualnosci',
	],
	[
		'label'  => inlife_t( 'Kontakt' ),
		'anchor' => 'kontakt',
	],
];
?>

<nav
	class="popielno-nav"
	aria-label="<?php echo esc_attr( inlife_t( 'Sekcje Stacji Badawczej w Popielnie' ) ); ?>"
>
	<div class="<?php echo esc_attr( inlife_container_class( 'content' ) ); ?>">
		<div class="popielno-nav__scroll">
			<ul class="c-pills popielno-nav__list">
				<?php foreach ( $items as $item ) : ?>
					<li>
						<a
							class="c-pill popielno-nav__link"
							href="#<?php echo esc_attr( $item['anchor'] ); ?>"
						>
							<?php echo esc_html( $item['label'] ); ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</nav>
<?php
defined( 'ABSPATH' ) || exit;

add_filter( 'block_categories_all', 'inlife_register_block_category', 10, 2 );

function inlife_register_block_category( $categories, $post ) {
	return array_merge(
		[
			[
				'slug'  => 'inlife',
				'title' => __( 'InLife', 'understrap-child' ),
				'icon'  => null,
			],
		],
		$categories
	);
}

add_action( 'acf/init', 'inlife_register_acf_blocks' );

function inlife_register_acf_blocks() {
	if ( ! function_exists( 'acf_register_block_type' ) ) {
		return;
	}

	$blocks = [
		[
			'name'        => 'inlife-heading',
			'title'       => __( 'InLife Heading', 'understrap-child' ),
			'description' => __( 'Nagłówek sekcyjny.', 'understrap-child' ),
			'template'    => 'block-heading.php',
			'icon'        => 'heading',
			'keywords'    => [ 'heading', 'nagłówek', 'tytuł' ],
		],
		[
			'name'        => 'inlife-image',
			'title'       => __( 'InLife Image', 'understrap-child' ),
			'description' => __( 'Pojedynczy obraz z podpisem.', 'understrap-child' ),
			'template'    => 'block-image.php',
			'icon'        => 'format-image',
			'keywords'    => [ 'image', 'obraz', 'zdjęcie' ],
		],
		[
			'name'        => 'inlife-gallery',
			'title'       => __( 'InLife Gallery', 'understrap-child' ),
			'description' => __( 'Kontrolowana galeria zdjęć.', 'understrap-child' ),
			'template'    => 'block-gallery.php',
			'icon'        => 'format-gallery',
			'keywords'    => [ 'gallery', 'galeria', 'zdjęcia' ],
		],
		[
			'name'        => 'inlife-buttons',
			'title'       => __( 'InLife Buttons', 'understrap-child' ),
			'description' => __( 'Przyciski CTA.', 'understrap-child' ),
			'template'    => 'block-buttons.php',
			'icon'        => 'button',
			'keywords'    => [ 'button', 'przycisk', 'cta' ],
		],
		[
			'name'        => 'inlife-highlight',
			'title'       => __( 'InLife Highlight', 'understrap-child' ),
			'description' => __( 'Wyróżniona informacja.', 'understrap-child' ),
			'template'    => 'block-highlight.php',
			'icon'        => 'info',
			'keywords'    => [ 'highlight', 'callout', 'wyróżnienie' ],
		],
		[
			'name'        => 'inlife-accordion',
			'title'       => __( 'InLife Accordion', 'understrap-child' ),
			'description' => __( 'Akordeon / FAQ.', 'understrap-child' ),
			'template'    => 'block-accordion.php',
			'icon'        => 'list-view',
			'keywords'    => [ 'accordion', 'faq', 'akordeon' ],
		],
		[
			'name'        => 'inlife-icon-list',
			'title'       => __( 'InLife Icon List', 'understrap-child' ),
			'description' => __( 'Lista elementów z ikonami.', 'understrap-child' ),
			'template'    => 'block-icon-list.php',
			'icon'        => 'editor-ul',
			'keywords'    => [ 'icons', 'ikony', 'lista' ],
		],
		[
			'name'        => 'inlife-card-grid',
			'title'       => __( 'InLife Card Grid', 'understrap-child' ),
			'description' => __( 'Siatka kart / linków.', 'understrap-child' ),
			'template'    => 'block-card-grid.php',
			'icon'        => 'grid-view',
			'keywords'    => [ 'cards', 'grid', 'karty' ],
		],
		[
			'name'        => 'inlife-downloads',
			'title'       => __( 'InLife Downloads', 'understrap-child' ),
			'description' => __( 'Lista plików do pobrania.', 'understrap-child' ),
			'template'    => 'block-downloads.php',
			'icon'        => 'download',
			'keywords'    => [ 'downloads', 'pliki', 'pobierz' ],
		],
		[
			'name'        => 'inlife-table',
			'title'       => __( 'InLife Table', 'understrap-child' ),
			'description' => __( 'Prosta tabela treści.', 'understrap-child' ),
			'template'    => 'block-table.php',
			'icon'        => 'editor-table',
			'keywords'    => [ 'table', 'tabela', 'dane' ],
		],
	];

	foreach ( $blocks as $block ) {
		acf_register_block_type(
			[
				'name'            => $block['name'],
				'title'           => $block['title'],
				'description'     => $block['description'],
				'render_template' => 'template-parts/blocks/' . $block['template'],
				'category'        => 'inlife',
				'icon'            => $block['icon'],
				'mode'            => 'preview',
				'keywords'        => $block['keywords'],
				'supports'        => [
					'align'  => false,
					'mode'   => true,
					'anchor' => true,
				],
			]
		);
	}
}
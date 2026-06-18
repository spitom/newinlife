<?php
/**
 * Block editor styles.
 *
 * @package newinlife-child
 */

defined( 'ABSPATH' ) || exit;

add_action( 'init', 'inlife_register_editor_block_styles' );

function inlife_register_editor_block_styles(): void {
	if ( ! function_exists( 'register_block_style' ) ) {
		return;
	}

	register_block_style(
		'core/paragraph',
		[
			'name'  => 'inlife-lead',
			'label' => __( 'Lead InLife', 'newinlife-child' ),
		]
	);

	register_block_style(
		'core/heading',
		[
			'name'  => 'inlife-section',
			'label' => __( 'Nagłówek sekcyjny InLife', 'newinlife-child' ),
		]
	);

	register_block_style(
		'core/list',
		[
			'name'  => 'inlife-checklist',
			'label' => __( 'Lista akcentowana InLife', 'newinlife-child' ),
		]
	);

	register_block_style(
		'core/list',
		[
			'name'  => 'inlife-clean',
			'label' => __( 'Lista liniowa InLife', 'newinlife-child' ),
		]
	);

	register_block_style(
		'core/table',
		[
			'name'  => 'inlife-formal',
			'label' => __( 'Tabela formalna InLife', 'newinlife-child' ),
		]
	);

	register_block_style(
		'core/table',
		[
			'name'  => 'inlife-compact',
			'label' => __( 'Tabela kompaktowa InLife', 'newinlife-child' ),
		]
	);
}
<?php
defined( 'ABSPATH' ) || exit;

$post_id = (int) get_option( 'page_on_front' );
$slides  = function_exists( 'get_field' ) ? get_field( 'front_hero_slides', $post_id ) : [];

if ( empty( $slides ) || ! is_array( $slides ) ) {
	return;
}
?>

<section class="front-section front-hero" aria-label="<?php echo esc_attr( inlife_t( 'Wyróżnione treści' ) ); ?>">
	<?php
	get_template_part(
		'template-parts/components/hero-slider',
		null,
		[
			'slides'  => $slides,
			'post_id' => $post_id,
		]
	);
	?>
</section>
<?php
defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

$type_slug = '';
$terms = get_the_terms( $post_id, 'people_type' );
if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
	$type_slug = $terms[0]->slug;
}

if ( 'scientific' !== $type_slug ) {
	return;
}

$publications = function_exists( 'get_field' ) ? get_field( 'person_selected_publications', $post_id ) : '';

if ( ! $publications ) {
	return;
}
?>

<div class="people-single-section">
	<h2 class="people-single-section__title"><?php esc_html_e( 'Wybrane publikacje', 'newinlife' ); ?></h2>
	<div class="people-single-section__content">
		<?php echo wp_kses_post( wpautop( $publications ) ); ?>
	</div>
</div>
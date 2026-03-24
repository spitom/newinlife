<?php
defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

$position = function_exists( 'get_field' ) ? get_field( 'person_position', $post_id ) : '';

$type_label = '';
$terms = get_the_terms( $post_id, 'people_type' );
if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
	$type_label = $terms[0]->name;
}
?>

<div class="people-single-header">

	<div class="people-single-header__media">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'large', ['class' => 'people-single-header__image'] ); ?>
		<?php else : ?>
			<div class="people-single-header__placeholder" aria-hidden="true"></div>
		<?php endif; ?>
	</div>

	<div class="people-single-header__content">

		<?php if ( $type_label ) : ?>
			<p class="people-single-header__type section-kicker">
				<?php echo esc_html( $type_label ); ?>
			</p>
		<?php endif; ?>

		<h1 class="people-single-header__title section-title">
			<?php the_title(); ?>
		</h1>

		<?php if ( $position ) : ?>
			<p class="people-single-header__position section-lead">
				<?php echo esc_html( $position ); ?>
			</p>
		<?php endif; ?>

	</div>

</div>
<?php
defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

$type_slug = '';
$terms = get_the_terms( $post_id, 'people_type' );
if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
	$type_slug = $terms[0]->slug;
}

$long_bio        = function_exists( 'get_field' ) ? get_field( 'person_long_bio', $post_id ) : '';
$interests       = function_exists( 'get_field' ) ? get_field( 'person_research_interests', $post_id ) : '';
$specializations = function_exists( 'get_field' ) ? get_field( 'person_specializations', $post_id ) : '';
?>

<div class="people-single-bio">
	<?php if ( 'staff' === $type_slug ) : ?>
		<?php if ( $long_bio ) : ?>
			<div class="people-single-section">
				<h2 class="people-single-section__title"><?php esc_html_e( 'Informacje', 'newinlife' ); ?></h2>
				<div class="people-single-section__content">
					<?php echo wp_kses_post( wpautop( $long_bio ) ); ?>
				</div>
			</div>
		<?php endif; ?>
	<?php endif; ?>

	<?php if ( 'scientific' === $type_slug ) : ?>
		<?php if ( $long_bio ) : ?>
			<div class="people-single-section">
				<h2 class="people-single-section__title"><?php esc_html_e( 'Profil', 'newinlife' ); ?></h2>
				<div class="people-single-section__content">
					<?php echo wp_kses_post( wpautop( $long_bio ) ); ?>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( $interests ) : ?>
			<div class="people-single-section">
				<h2 class="people-single-section__title"><?php esc_html_e( 'Najważniejsze publikacje', 'newinlife' ); ?></h2>
				<div class="people-single-section__content">
					<?php echo wp_kses_post( wpautop( $interests ) ); ?>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( $specializations ) : ?>
			<div class="people-single-section">
				<h2 class="people-single-section__title"><?php esc_html_e( 'Specjalizacje / słowa kluczowe', 'newinlife' ); ?></h2>
				<div class="people-single-section__content">
					<?php echo wp_kses_post( wpautop( $specializations ) ); ?>
				</div>
			</div>
		<?php endif; ?>
	<?php endif; ?>
</div>
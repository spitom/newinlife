<?php
defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

$type_slug = '';
$terms     = get_the_terms( $post_id, 'people_type' );

if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
	$type_slug = $terms[0]->slug;
}

$long_bio        = function_exists( 'get_field' ) ? get_field( 'person_long_bio', $post_id ) : '';
$interests       = function_exists( 'get_field' ) ? get_field( 'person_research_interests', $post_id ) : '';
$specializations = function_exists( 'get_field' ) ? get_field( 'person_specializations', $post_id ) : '';
?>

<div class="people-profile-content">
	<?php if ( $long_bio ) : ?>
		<section class="people-profile-section">
			<h2 class="people-profile-section__title">
				<?php echo 'staff' === $type_slug ? esc_html__( 'Informacje', 'newinlife' ) : esc_html__( 'Profil naukowy', 'newinlife' ); ?>
			</h2>

			<div class="people-profile-section__content c-editorial-content">
				<?php echo wp_kses_post( wpautop( $long_bio ) ); ?>
			</div>
		</section>
	<?php endif; ?>

	<?php if ( 'scientific' === $type_slug && $interests ) : ?>
		<section class="people-profile-section">
			<h2 class="people-profile-section__title">
				<?php esc_html_e( 'Najważniejsze publikacje', 'newinlife' ); ?>
			</h2>

			<div class="people-profile-section__content c-editorial-content">
				<?php echo wp_kses_post( wpautop( $interests ) ); ?>
			</div>
		</section>
	<?php endif; ?>

	<?php if ( 'scientific' === $type_slug && $specializations ) : ?>
		<section class="people-profile-section">
			<h2 class="people-profile-section__title">
				<?php esc_html_e( 'Specjalizacje / słowa kluczowe', 'newinlife' ); ?>
			</h2>

			<div class="people-profile-section__content c-editorial-content">
				<?php echo wp_kses_post( wpautop( $specializations ) ); ?>
			</div>
		</section>
	<?php endif; ?>
</div>
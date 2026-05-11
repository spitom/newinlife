<?php
defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

$linkedin = function_exists( 'get_field' ) ? get_field( 'person_linkedin', $post_id ) : '';
$orcid    = function_exists( 'get_field' ) ? get_field( 'person_orcid', $post_id ) : '';
$scholar  = function_exists( 'get_field' ) ? get_field( 'person_google_scholar', $post_id ) : '';
$rg       = function_exists( 'get_field' ) ? get_field( 'person_researchgate', $post_id ) : '';

$type_slug = '';
$terms     = get_the_terms( $post_id, 'people_type' );

if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
	$type_slug = $terms[0]->slug;
}

if ( 'scientific' !== $type_slug || ( ! $linkedin && ! $orcid && ! $scholar && ! $rg ) ) {
	return;
}
?>

<section class="people-profile-aside-section people-profile-aside-section--profiles">
	<h2 class="people-profile-aside-section__title">
		<?php echo esc_html( inlife_t( 'Linki' ) ); ?>
	</h2>

	<div class="people-profile-links" role="list">
		<?php if ( $orcid ) : ?>
			<a href="<?php echo esc_url( $orcid ); ?>" target="_blank" rel="noopener" class="people-profile-links__item people-profile-links__item--orcid">
				<span class="people-profile-links__icon" aria-hidden="true">iD</span>
				<span class="people-profile-links__label">ORCID</span>
				<i class="bi bi-box-arrow-up-right people-profile-links__external" aria-hidden="true"></i>
			</a>
		<?php endif; ?>

		<?php if ( $scholar ) : ?>
			<a href="<?php echo esc_url( $scholar ); ?>" target="_blank" rel="noopener" class="people-profile-links__item people-profile-links__item--scholar">
				<span class="people-profile-links__icon" aria-hidden="true">G</span>
				<span class="people-profile-links__label">Google Scholar</span>
				<i class="bi bi-box-arrow-up-right people-profile-links__external" aria-hidden="true"></i>
			</a>
		<?php endif; ?>

		<?php if ( $rg ) : ?>
			<a href="<?php echo esc_url( $rg ); ?>" target="_blank" rel="noopener" class="people-profile-links__item people-profile-links__item--researchgate">
				<span class="people-profile-links__icon" aria-hidden="true">R<sup>G</sup></span>
				<span class="people-profile-links__label">ResearchGate</span>
				<i class="bi bi-box-arrow-up-right people-profile-links__external" aria-hidden="true"></i>
			</a>
		<?php endif; ?>

		<?php if ( $linkedin ) : ?>
			<a href="<?php echo esc_url( $linkedin ); ?>" target="_blank" rel="noopener" class="people-profile-links__item people-profile-links__item--linkedin">
				<span class="people-profile-links__icon" aria-hidden="true">
					<i class="bi bi-linkedin"></i>
				</span>
				<span class="people-profile-links__label">LinkedIn</span>
				<i class="bi bi-box-arrow-up-right people-profile-links__external" aria-hidden="true"></i>
			</a>
		<?php endif; ?>
	</div>
</section>
<?php
defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

$linkedin = function_exists( 'get_field' ) ? get_field( 'person_linkedin', $post_id ) : '';
$orcid    = function_exists( 'get_field' ) ? get_field( 'person_orcid', $post_id ) : '';
$scholar  = function_exists( 'get_field' ) ? get_field( 'person_google_scholar', $post_id ) : '';
$rg       = function_exists( 'get_field' ) ? get_field( 'person_researchgate', $post_id ) : '';

$type_slug = '';
$terms = get_the_terms( $post_id, 'people_type' );
if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
	$type_slug = $terms[0]->slug;
}

if ( 'scientific' !== $type_slug || ( ! $linkedin && ! $orcid && ! $scholar && ! $rg ) ) {
	return;
}
?>

<div class="people-single-panel c-surface c-surface--panel">
	<h2 class="people-single-panel__title">
		<?php esc_html_e( 'Profile i identyfikatory', 'newinlife' ); ?>
	</h2>

	<div class="people-single-links" role="list">
		<?php if ( $orcid ) : ?>
			<a
				href="<?php echo esc_url( $orcid ); ?>"
				target="_blank"
				rel="noopener"
				class="people-single-links__item"
				aria-label="<?php esc_attr_e( 'Profil ORCID', 'newinlife' ); ?>"
				title="<?php esc_attr_e( 'ORCID', 'newinlife' ); ?>"
			>
				<span class="people-single-links__icon" aria-hidden="true">iD</span>
				<span class="people-single-links__label">ORCID</span>
			</a>
		<?php endif; ?>

		<?php if ( $linkedin ) : ?>
			<a
				href="<?php echo esc_url( $linkedin ); ?>"
				target="_blank"
				rel="noopener"
				class="people-single-links__item"
				aria-label="<?php esc_attr_e( 'Profil LinkedIn', 'newinlife' ); ?>"
				title="<?php esc_attr_e( 'LinkedIn', 'newinlife' ); ?>"
			>
				<i class="bi bi-linkedin people-single-links__icon" aria-hidden="true"></i>
				<span class="people-single-links__label">LinkedIn</span>
			</a>
		<?php endif; ?>

		<?php if ( $scholar ) : ?>
			<a
				href="<?php echo esc_url( $scholar ); ?>"
				target="_blank"
				rel="noopener"
				class="people-single-links__item"
				aria-label="<?php esc_attr_e( 'Profil Google Scholar', 'newinlife' ); ?>"
				title="<?php esc_attr_e( 'Google Scholar', 'newinlife' ); ?>"
			>
				<i class="bi bi-mortarboard people-single-links__icon" aria-hidden="true"></i>
				<span class="people-single-links__label">Scholar</span>
			</a>
		<?php endif; ?>

		<?php if ( $rg ) : ?>
			<a
				href="<?php echo esc_url( $rg ); ?>"
				target="_blank"
				rel="noopener"
				class="people-single-links__item"
				aria-label="<?php esc_attr_e( 'Profil ResearchGate', 'newinlife' ); ?>"
				title="<?php esc_attr_e( 'ResearchGate', 'newinlife' ); ?>"
			>
				<i class="bi bi-journal-text people-single-links__icon" aria-hidden="true"></i>
				<span class="people-single-links__label">ResearchGate</span>
			</a>
		<?php endif; ?>
	</div>
</div>
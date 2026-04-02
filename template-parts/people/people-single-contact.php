<?php
defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

$email = function_exists( 'get_field' ) ? get_field( 'person_email', $post_id ) : '';
$phone = function_exists( 'get_field' ) ? get_field( 'person_phone', $post_id ) : '';
$room  = function_exists( 'get_field' ) ? get_field( 'person_room', $post_id ) : '';

$linkedin = function_exists( 'get_field' ) ? get_field( 'person_linkedin', $post_id ) : '';
$orcid    = function_exists( 'get_field' ) ? get_field( 'person_orcid', $post_id ) : '';
$scholar  = function_exists( 'get_field' ) ? get_field( 'person_google_scholar', $post_id ) : '';
$rg       = function_exists( 'get_field' ) ? get_field( 'person_researchgate', $post_id ) : '';

$type_slug = '';
$terms = get_the_terms( $post_id, 'people_type' );
if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
	$type_slug = $terms[0]->slug;
}

if ( ! $email && ! $phone && ! $room && ! $linkedin && ! $orcid && ! $scholar && ! $rg ) {
	return;
}
?>

<div class="people-single-panel">
	<h2 class="people-single-panel__title">
		<?php esc_html_e( 'Kontakt', 'newinlife' ); ?>
	</h2>

	<div class="people-single-contact-list">
		<?php if ( $email ) : ?>
			<div class="people-single-contact-list__item">
				<span class="people-single-contact-list__label"><?php esc_html_e( 'E-mail', 'newinlife' ); ?></span>
				<a href="mailto:<?php echo esc_attr( antispambot( $email ) ); ?>">
					<?php echo esc_html( antispambot( $email ) ); ?>
				</a>
			</div>
		<?php endif; ?>

		<?php if ( $phone ) : ?>
			<div class="people-single-contact-list__item">
				<span class="people-single-contact-list__label"><?php esc_html_e( 'Telefon', 'newinlife' ); ?></span>
				<a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $phone ) ); ?>">
					<?php echo esc_html( $phone ); ?>
				</a>
			</div>
		<?php endif; ?>

		<?php if ( $room ) : ?>
			<div class="people-single-contact-list__item">
				<span class="people-single-contact-list__label"><?php esc_html_e( 'Pokój / lokalizacja', 'newinlife' ); ?></span>
				<span><?php echo esc_html( $room ); ?></span>
			</div>
		<?php endif; ?>
	</div>

	<?php if ( 'scientific' === $type_slug && ( $orcid || $linkedin || $scholar || $rg ) ) : ?>
		<div class="people-single-links">
			<?php if ( $orcid ) : ?>
				<a href="<?php echo esc_url( $orcid ); ?>" target="_blank" rel="noopener">ORCID</a>
			<?php endif; ?>

			<?php if ( $linkedin ) : ?>
				<a href="<?php echo esc_url( $linkedin ); ?>" target="_blank" rel="noopener">LinkedIn</a>
			<?php endif; ?>

			<?php if ( $scholar ) : ?>
				<a href="<?php echo esc_url( $scholar ); ?>" target="_blank" rel="noopener">Google Scholar</a>
			<?php endif; ?>

			<?php if ( $rg ) : ?>
				<a href="<?php echo esc_url( $rg ); ?>" target="_blank" rel="noopener">ResearchGate</a>
			<?php endif; ?>
		</div>
	<?php endif; ?>
</div>
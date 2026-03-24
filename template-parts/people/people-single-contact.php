<?php
defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

$email = get_field( 'person_email', $post_id );
$phone = get_field( 'person_phone', $post_id );
$room  = get_field( 'person_room', $post_id );

$linkedin = get_field( 'person_linkedin', $post_id );
$orcid    = get_field( 'person_orcid', $post_id );
$scholar  = get_field( 'person_google_scholar', $post_id );
$rg       = get_field( 'person_researchgate', $post_id );

if ( ! $email && ! $phone && ! $room && ! $linkedin && ! $orcid && ! $scholar && ! $rg ) {
	return;
}
?>

<div class="people-single-panel">
	<h2 class="people-single-panel__title">
		<?php esc_html_e( 'Kontakt', 'newinlife' ); ?>
	</h2>

	<?php if ( $email ) : ?>
		<p>
			<a href="mailto:<?php echo esc_attr( antispambot( $email ) ); ?>">
				<?php echo esc_html( antispambot( $email ) ); ?>
			</a>
		</p>
	<?php endif; ?>

	<?php if ( $phone ) : ?>
		<p>
			<a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $phone ) ); ?>">
				<?php echo esc_html( $phone ); ?>
			</a>
		</p>
	<?php endif; ?>

	<?php if ( $room ) : ?>
		<p><?php echo esc_html( $room ); ?></p>
	<?php endif; ?>

	<?php if ( $linkedin ) : ?>
		<p><a href="<?php echo esc_url( $linkedin ); ?>" target="_blank" rel="noopener">LinkedIn</a></p>
	<?php endif; ?>

	<?php if ( $orcid ) : ?>
		<p><a href="<?php echo esc_url( $orcid ); ?>" target="_blank" rel="noopener">ORCID</a></p>
	<?php endif; ?>

	<?php if ( $scholar ) : ?>
		<p><a href="<?php echo esc_url( $scholar ); ?>" target="_blank" rel="noopener">Google Scholar</a></p>
	<?php endif; ?>

	<?php if ( $rg ) : ?>
		<p><a href="<?php echo esc_url( $rg ); ?>" target="_blank" rel="noopener">ResearchGate</a></p>
	<?php endif; ?>

</div>
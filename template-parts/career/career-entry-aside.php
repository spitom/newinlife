<?php
/**
 * Career entry aside
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

$unit            = function_exists( 'get_field' ) ? get_field( 'career_unit', $post_id ) : '';
$position_label  = function_exists( 'get_field' ) ? get_field( 'career_position_label', $post_id ) : '';
$employment_type = function_exists( 'get_field' ) ? get_field( 'career_employment_type', $post_id ) : '';
$location        = function_exists( 'get_field' ) ? get_field( 'career_location', $post_id ) : '';
$deadline_raw    = function_exists( 'get_field' ) ? get_field( 'career_deadline', $post_id ) : '';
$contact_email   = function_exists( 'get_field' ) ? get_field( 'career_contact_email', $post_id ) : '';
$contact_phone   = function_exists( 'get_field' ) ? get_field( 'career_contact_phone', $post_id ) : '';

$deadline = function_exists( 'inlife_format_career_date' )
	? inlife_format_career_date( $deadline_raw )
	: '';

$attachments = [];

if ( function_exists( 'have_rows' ) && have_rows( 'career_files', $post_id ) ) {
	while ( have_rows( 'career_files', $post_id ) ) {
		the_row();

		$file = get_sub_field( 'file' );
		$title = get_sub_field( 'title' );

		if ( is_array( $file ) && ! empty( $file['url'] ) ) {
			$attachments[] = [
				'title' => $title ? $title : ( $file['title'] ?? inlife_t( 'Pobierz plik' ) ),
				'url'   => $file['url'],
			];
		}
	}
}

/**
 * Fallback for older field structure, if needed.
 */
if ( empty( $attachments ) && function_exists( 'get_field' ) ) {
	$legacy_files = get_field( 'career_attachments', $post_id );

	if ( is_array( $legacy_files ) ) {
		foreach ( $legacy_files as $file ) {
			if ( is_array( $file ) && ! empty( $file['url'] ) ) {
				$attachments[] = [
					'title' => ! empty( $file['title'] ) ? $file['title'] : inlife_t( 'Pobierz plik' ),
					'url'   => $file['url'],
				];
			}
		}
	}
}

$has_info_panel = $unit || $position_label || $employment_type || $location || $deadline;
$has_contact    = $contact_email || $contact_phone;
?>

<div class="career-entry-aside">

	<?php if ( $has_info_panel ) : ?>
		<section class="career-entry-aside__section c-surface c-surface--panel" aria-labelledby="career-entry-info-heading">
			<h2 id="career-entry-info-heading" class="career-entry-aside__heading">
				<?php echo esc_html( inlife_t( 'Informacje' ) ); ?>
			</h2>

			<ul class="career-entry-aside__list">
				<?php if ( $unit ) : ?>
					<li>
						<span class="career-entry-aside__label"><?php echo esc_html( inlife_t( 'Jednostka' ) ); ?></span>
						<span class="career-entry-aside__value"><?php echo esc_html( $unit ); ?></span>
					</li>
				<?php endif; ?>

				<?php if ( $position_label ) : ?>
					<li>
						<span class="career-entry-aside__label"><?php echo esc_html( inlife_t( 'Stanowisko' ) ); ?></span>
						<span class="career-entry-aside__value"><?php echo esc_html( $position_label ); ?></span>
					</li>
				<?php endif; ?>

				<?php if ( $employment_type ) : ?>
					<li>
						<span class="career-entry-aside__label"><?php echo esc_html( inlife_t( 'Forma zatrudnienia' ) ); ?></span>
						<span class="career-entry-aside__value"><?php echo esc_html( $employment_type ); ?></span>
					</li>
				<?php endif; ?>

				<?php if ( $location ) : ?>
					<li>
						<span class="career-entry-aside__label"><?php echo esc_html( inlife_t( 'Lokalizacja' ) ); ?></span>
						<span class="career-entry-aside__value"><?php echo esc_html( $location ); ?></span>
					</li>
				<?php endif; ?>

				<?php if ( $deadline ) : ?>
					<li>
						<span class="career-entry-aside__label"><?php echo esc_html( inlife_t( 'Termin składania' ) ); ?></span>
						<span class="career-entry-aside__value career-entry-aside__value--deadline">
							<?php echo esc_html( $deadline ); ?>
						</span>
					</li>
				<?php endif; ?>
			</ul>
		</section>
	<?php endif; ?>

	<?php if ( ! empty( $attachments ) ) : ?>
		<section class="career-entry-aside__section c-surface c-surface--panel" aria-labelledby="career-entry-documents-heading">
			<h2 id="career-entry-documents-heading" class="career-entry-aside__heading">
				<?php echo esc_html( inlife_t( 'Dokumenty' ) ); ?>
			</h2>

			<ul class="career-entry-aside__links">
				<?php foreach ( $attachments as $file ) : ?>
					<li>
						<a href="<?php echo esc_url( $file['url'] ); ?>" target="_blank" rel="noopener noreferrer">
							<?php echo esc_html( $file['title'] ); ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</section>
	<?php endif; ?>

	<?php if ( $has_contact ) : ?>
		<section class="career-entry-aside__section c-surface c-surface--panel" aria-labelledby="career-entry-contact-heading">
			<h2 id="career-entry-contact-heading" class="career-entry-aside__heading">
				<?php echo esc_html( inlife_t( 'Kontakt' ) ); ?>
			</h2>

			<ul class="career-entry-aside__list">
				<?php if ( $contact_email ) : ?>
					<li>
						<span class="career-entry-aside__label"><?php echo esc_html( inlife_t( 'E-mail' ) ); ?></span>
						<span class="career-entry-aside__value">
							<a href="mailto:<?php echo esc_attr( antispambot( $contact_email ) ); ?>">
								<?php echo esc_html( antispambot( $contact_email ) ); ?>
							</a>
						</span>
					</li>
				<?php endif; ?>

				<?php if ( $contact_phone ) : ?>
					<li>
						<span class="career-entry-aside__label"><?php echo esc_html( inlife_t( 'Telefon' ) ); ?></span>
						<span class="career-entry-aside__value">
							<a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $contact_phone ) ); ?>">
								<?php echo esc_html( $contact_phone ); ?>
							</a>
						</span>
					</li>
				<?php endif; ?>
			</ul>
		</section>
	<?php endif; ?>

</div>
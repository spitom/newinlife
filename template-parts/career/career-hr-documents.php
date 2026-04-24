<?php
/**
 * Career HR documents
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

if ( ! function_exists( 'inlife_get_acf_field' ) ) {
	function inlife_get_acf_field( $field_name, $post_id = 0, $default = null ) {
		if ( function_exists( 'get_field' ) ) {
			$value = get_field( $field_name, $post_id );

			if ( null !== $value && '' !== $value ) {
				return $value;
			}
		}

		return $default;
	}
}

$section_kicker = inlife_get_acf_field( 'career_hr_documents_kicker', $post_id, inlife_t( 'Standardy' ) );
$section_title  = inlife_get_acf_field( 'career_hr_documents_title', $post_id, inlife_t( 'HR Excellence in Research' ) );
$section_text   = inlife_get_acf_field(
	'career_hr_documents_text',
	$post_id,
	inlife_t( 'HR Excellence in Research to europejskie wyróżnienie przyznawane organizacjom badawczym, które rozwijają politykę kadrową zgodnie z zasadami Europejskiej Karty dla Naukowców.' )
);

$logo     = inlife_get_acf_field( 'career_hr_documents_logo', $post_id, null );
$logo_url = '';
$logo_alt = 'HR Excellence in Research';

if ( is_array( $logo ) && ! empty( $logo['url'] ) ) {
	$logo_url = $logo['url'];
	$logo_alt = ! empty( $logo['alt'] ) ? $logo['alt'] : $logo_alt;
} else {
	$logo_url = get_stylesheet_directory_uri() . '/assets/images/HR-excellence-in-research.png';
}

$documents = [];

if ( function_exists( 'have_rows' ) && have_rows( 'career_hr_documents', $post_id ) ) {
	while ( have_rows( 'career_hr_documents', $post_id ) ) {
		the_row();

		$file = get_sub_field( 'document_file' );
		$url  = '';

		if ( is_array( $file ) && ! empty( $file['url'] ) ) {
			$url = $file['url'];
		} elseif ( is_string( $file ) && '' !== trim( $file ) ) {
			$url = $file;
		}

		$title = get_sub_field( 'document_title' );
		$desc  = get_sub_field( 'short_description' );

		if ( ! $title || ! $url ) {
			continue;
		}

		$documents[] = [
			'title' => $title,
			'desc'  => $desc,
			'url'   => $url,
		];
	}
}
?>

<div class="career-hr-documents">

	<div class="career-hr-documents__intro">
		<div class="career-hr-documents__intro-content">
			<p class="career-hr-documents__kicker">
				<?php echo esc_html( $section_kicker ); ?>
			</p>

			<h2 id="career-hr-documents-heading" class="career-hr-documents__heading">
				<?php echo esc_html( $section_title ); ?>
			</h2>

			<?php if ( $section_text ) : ?>
				<div class="career-hr-documents__lead">
					<?php echo wp_kses_post( wpautop( $section_text ) ); ?>
				</div>
			<?php endif; ?>
		</div>

		<?php if ( $logo_url ) : ?>
			<div class="career-hr-documents__media" aria-hidden="true">
				<img
					class="career-hr-documents__logo"
					src="<?php echo esc_url( $logo_url ); ?>"
					alt=""
					loading="lazy"
					decoding="async"
				>
			</div>
		<?php endif; ?>
	</div>

	<?php if ( ! empty( $documents ) ) : ?>
		<div class="career-hr-documents__downloads" aria-labelledby="career-hr-documents-downloads-heading">
			<h3 id="career-hr-documents-downloads-heading" class="career-hr-documents__downloads-title">
				<?php echo esc_html( inlife_t( 'Dokumenty do pobrania' ) ); ?>
			</h3>

			<div class="career-hr-documents__list">
				<?php foreach ( $documents as $document ) : ?>
					<article class="career-hr-documents__item">
						<div class="career-hr-documents__item-content">
							<h4 class="career-hr-documents__item-title">
								<?php echo esc_html( $document['title'] ); ?>
							</h4>

							<?php if ( ! empty( $document['desc'] ) ) : ?>
								<div class="career-hr-documents__item-text">
									<?php echo wp_kses_post( wpautop( $document['desc'] ) ); ?>
								</div>
							<?php endif; ?>
						</div>

						<a
							class="c-readmore career-hr-documents__download"
							href="<?php echo esc_url( $document['url'] ); ?>"
							target="_blank"
							rel="noopener noreferrer"
						>
							<span class="c-readmore__label">
								<?php echo esc_html( inlife_t( 'Pobierz dokument' ) ); ?>
							</span>
							<span class="c-readmore__icon" aria-hidden="true">→</span>
						</a>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endif; ?>

</div>
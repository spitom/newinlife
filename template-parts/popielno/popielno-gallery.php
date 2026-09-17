<?php
/**
 * Popielno — Gallery.
 *
 * @package newinlife-child
 */

defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

$kicker = function_exists( 'inlife_get_acf_field' )
	? trim( (string) inlife_get_acf_field( 'popielno_gallery_kicker', $post_id, '' ) )
	: '';

$title = function_exists( 'inlife_get_acf_field' )
	? trim( (string) inlife_get_acf_field( 'popielno_gallery_title', $post_id, '' ) )
	: '';

$lead = function_exists( 'inlife_get_acf_field' )
	? (string) inlife_get_acf_field( 'popielno_gallery_lead', $post_id, '' )
	: '';

$gallery = function_exists( 'get_field' )
	? get_field( 'popielno_gallery', $post_id )
	: [];

if ( '' === $kicker ) {
	$kicker = inlife_t( 'Galeria' );
}

if ( '' === $title ) {
	$title = inlife_t( 'Popielno w obiektywie' );
}

if ( ! is_array( $gallery ) || empty( $gallery ) ) {
	return;
}

$image_ids = [];

foreach ( $gallery as $image ) {
	if ( is_array( $image ) && ! empty( $image['ID'] ) ) {
		$image_ids[] = (int) $image['ID'];
	} elseif ( is_numeric( $image ) ) {
		$image_ids[] = (int) $image;
	}
}

$image_ids = array_values( array_filter( $image_ids ) );

if ( empty( $image_ids ) ) {
	return;
}

$valid_image_ids   = [];
$lightbox_sources  = [];

foreach ( $image_ids as $image_id ) {
	$full = wp_get_attachment_image_src( $image_id, 'full' );

	if ( ! $full ) {
		continue;
	}

	$srcset = wp_get_attachment_image_srcset( $image_id, 'full' );
	$sizes  = wp_get_attachment_image_sizes( $image_id, 'full' );
	$alt    = get_post_meta( $image_id, '_wp_attachment_image_alt', true );

	$valid_image_ids[] = $image_id;

	$lightbox_sources[] = [
		'src'    => $full[0],
		'srcset' => $srcset ?: '',
		'sizes'  => $sizes ?: '',
		'alt'    => (string) $alt,
	];
}

if ( empty( $valid_image_ids ) ) {
	return;
}

$preview_images = array_slice( $valid_image_ids, 0, 6 );
?>

<section
	id="galeria"
	class="page-section popielno-gallery"
	aria-labelledby="popielno-gallery-heading"
>
	<div class="<?php echo esc_attr( inlife_container_class( 'content' ) ); ?>">

		<?php
		get_template_part(
			'template-parts/components/section-header',
			null,
			[
				'kicker'   => $kicker,
				'title'    => $title,
				'lead'     => $lead,
				'title_id' => 'popielno-gallery-heading',
			]
		);
		?>

		<div class="popielno-gallery__grid">

			<?php foreach ( $preview_images as $index => $image_id ) : ?>
                <figure class="popielno-gallery__item popielno-gallery__item--<?php echo esc_attr( $index + 1 ); ?>">
                    <button
                        type="button"
                        class="popielno-gallery__button"
                        data-inlife-lightbox-open="popielno-gallery"
                        data-inlife-lightbox-index="<?php echo esc_attr( $index ); ?>"
                        aria-label="<?php echo esc_attr( inlife_t( 'Powiększ zdjęcie' ) ); ?>"
                    >
                        <?php
                        echo wp_get_attachment_image(
                            $image_id,
                            'large',
                            false,
                            [
                                'class'   => 'popielno-gallery__image',
                                'loading' => 0 === $index ? 'eager' : 'lazy',
                            ]
                        );
                        ?>
                        <?php if ( 5 === $index && count( $valid_image_ids ) > 6 ) : ?>
                            <span class="popielno-gallery__more">
                                <span class="popielno-gallery__more-label">
                                    <?php echo esc_html( inlife_t( 'Zobacz całą galerię' ) ); ?>
                                </span>
                            </span>
                        <?php endif; ?>
                    </button>
                </figure>
            <?php endforeach; ?>

		</div>

        <?php if ( ! empty( $lightbox_sources ) ) : ?>
            <dialog
                class="inlife-lightbox"
                data-inlife-lightbox="popielno-gallery"
                aria-label="<?php echo esc_attr( inlife_t( 'Galeria zdjęć Popielna' ) ); ?>"
            >
                <button
                    type="button"
                    class="inlife-lightbox__close"
                    data-inlife-lightbox-close
                    aria-label="<?php echo esc_attr( inlife_t( 'Zamknij galerię' ) ); ?>"
                >
                    <span aria-hidden="true">×</span>
                </button>

                <button
                    type="button"
                    class="inlife-lightbox__nav inlife-lightbox__nav--prev"
                    data-inlife-lightbox-prev
                    aria-label="<?php echo esc_attr( inlife_t( 'Poprzednie zdjęcie' ) ); ?>"
                >
                    <span aria-hidden="true">←</span>
                </button>

                <div class="inlife-lightbox__stage">
                    <img
                        class="inlife-lightbox__image"
                        data-inlife-lightbox-image
                        src=""
                        alt=""
                    >
                </div>

                <button
                    type="button"
                    class="inlife-lightbox__nav inlife-lightbox__nav--next"
                    data-inlife-lightbox-next
                    aria-label="<?php echo esc_attr( inlife_t( 'Następne zdjęcie' ) ); ?>"
                >
                    <span aria-hidden="true">→</span>
                </button>

                <div
                    class="inlife-lightbox__counter"
                    data-inlife-lightbox-counter
                    aria-live="polite"
                ></div>

                <div class="inlife-lightbox__sources" hidden>
                    <?php foreach ( $lightbox_sources as $source ) : ?>
                        <span
                            data-inlife-lightbox-source
                            data-src="<?php echo esc_url( $source['src'] ); ?>"
                            data-srcset="<?php echo esc_attr( $source['srcset'] ); ?>"
                            data-sizes="<?php echo esc_attr( $source['sizes'] ); ?>"
                            data-alt="<?php echo esc_attr( $source['alt'] ); ?>"
                        ></span>
                    <?php endforeach; ?>
                </div>
            </dialog>
        <?php endif; ?>

	</div>
</section>

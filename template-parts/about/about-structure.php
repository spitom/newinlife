<?php
defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

$title = inlife_get_acf_field(
	'about_structure_title',
	$post_id,
	inlife_t( 'Struktura organizacyjna' )
);

$text = inlife_get_acf_field(
	'about_structure_text',
	$post_id,
	inlife_t( 'Poznaj strukturę Instytutu, zespoły badawcze, laboratoria oraz jednostki wspierające działalność naukową i organizacyjną.' )
);

$link  = inlife_get_acf_field( 'about_structure_link', $post_id, null );
$image = inlife_get_acf_field( 'about_structure_image', $post_id, 0 );

$url   = is_array( $link ) && ! empty( $link['url'] ) ? $link['url'] : '';
$label = is_array( $link ) && ! empty( $link['title'] ) ? $link['title'] : inlife_t( 'Zobacz pełną strukturę Instytutu' );

$image_id = 0;

if ( is_array( $image ) && ! empty( $image['ID'] ) ) {
	$image_id = (int) $image['ID'];
} elseif ( is_numeric( $image ) ) {
	$image_id = (int) $image;
}
?>

<div class="about-structure">

	<div class="about-structure__content">
		<p class="about-structure__kicker">
			<?php echo esc_html( inlife_t( 'Poznaj Instytut' ) ); ?>
		</p>

		<h2 id="about-structure-heading" class="about-structure__title">
			<?php echo esc_html( $title ); ?>
		</h2>

		<?php if ( $text ) : ?>
			<p class="about-structure__text">
				<?php echo esc_html( $text ); ?>
			</p>
		<?php endif; ?>

		<?php if ( $url ) : ?>
			<a class="c-readmore about-structure__readmore" href="<?php echo esc_url( $url ); ?>">
				<?php echo esc_html( $label ); ?>
				<span class="c-readmore__icon" aria-hidden="true">→</span>
			</a>
		<?php endif; ?>
	</div>

	<div class="about-structure__media">
		<?php if ( $image_id ) : ?>
			<?php
			echo wp_get_attachment_image(
				$image_id,
				'large',
				false,
				[
					'class'   => 'about-structure__image',
					'loading' => 'lazy',
					'alt'     => '',
				]
			);
			?>
		<?php else : ?>
			<div class="about-structure__placeholder" aria-hidden="true">
				<span><?php echo esc_html( inlife_t( 'Struktura' ) ); ?></span>
			</div>
		<?php endif; ?>
	</div>

</div>
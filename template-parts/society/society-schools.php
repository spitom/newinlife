<?php
/**
 * Society - Schools
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

$post_id   = $args['post_id'] ?? get_the_ID();
$container = $args['container'] ?? ( function_exists( 'inlife_container_class' ) ? inlife_container_class() : 'container' );

$kicker          = inlife_get_acf_field( 'schools_kicker', $post_id, '' );
$title           = inlife_get_acf_field( 'schools_title', $post_id, '' );
$text            = inlife_get_acf_field( 'schools_text', $post_id, '' );
$form_shortcode  = inlife_get_acf_field( 'schools_form_shortcode', $post_id, '' );

$title = inlife_get_acf_field(
	'schools_title',
	$post_id,
	inlife_t( 'Spotkaj się z nami' )
);

if ( empty( $text ) && empty( $form_shortcode ) ) {
	return;
}
?>

<section class="society-section society-section--schools" aria-labelledby="society-schools-heading">
	<div class="society-schools">
		<div class="<?php echo esc_attr( $container ); ?>">
			<div class="society-schools__inner">

				<div class="society-schools__content">
					<?php
					get_template_part(
						'template-parts/components/section-header',
						null,
						[
							'kicker'   => $kicker,
							'title'    => $title,
							'lead'     => '',
							'title_id' => 'society-schools-heading',
						]
					);
					?>

					<?php if ( $text ) : ?>
						<div class="society-schools__text">
							<?php echo wp_kses_post( $text ); ?>
						</div>
					<?php endif; ?>
				</div>

				<?php if ( $form_shortcode ) : ?>
					<div class="society-schools__form inlife-form inlife-form--dark">
						<?php echo do_shortcode( wp_kses_post( $form_shortcode ) ); ?>
					</div>
				<?php endif; ?>

			</div>
		</div>
	</div>
</section>
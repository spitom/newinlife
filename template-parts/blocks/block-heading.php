<?php
defined( 'ABSPATH' ) || exit;

$block_id = ! empty( $block['anchor'] ) ? $block['anchor'] : 'inlife-heading-' . $block['id'];

$kicker = get_field( 'block_heading_kicker' );
$title  = get_field( 'block_heading_title' );
$lead   = get_field( 'block_heading_lead' );
$level  = get_field( 'block_heading_level' ) ?: 'h2';

$allowed_levels = [ 'h2', 'h3', 'h4' ];

if ( ! in_array( $level, $allowed_levels, true ) ) {
	$level = 'h2';
}

if ( ! $kicker && ! $title && ! $lead ) {
	return;
}
?>

<section id="<?php echo esc_attr( $block_id ); ?>" class="inlife-block inlife-block-heading">
	<header class="section-heading">

		<?php if ( $kicker ) : ?>
			<p class="section-kicker"><?php echo esc_html( $kicker ); ?></p>
		<?php endif; ?>

		<?php if ( $title ) : ?>
			<<?php echo esc_attr( $level ); ?> class="section-title">
				<?php echo esc_html( $title ); ?>
			</<?php echo esc_attr( $level ); ?>>
		<?php endif; ?>

		<?php if ( $lead ) : ?>
			<div class="section-lead c-editorial-content">
				<?php echo wp_kses_post( $lead ); ?>
			</div>
		<?php endif; ?>

	</header>
</section>
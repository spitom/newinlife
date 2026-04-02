<?php
defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

$type_slug  = '';
$type_label = '';

$terms = get_the_terms( $post_id, 'people_type' );
if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
	$type_slug  = $terms[0]->slug;
	$type_label = $terms[0]->name;
}

$academic_title = function_exists( 'get_field' ) ? get_field( 'person_academic_title', $post_id ) : '';
$position       = function_exists( 'get_field' ) ? get_field( 'person_position', $post_id ) : '';
$short_bio      = function_exists( 'get_field' ) ? get_field( 'person_short_bio', $post_id ) : '';

$name = trim( get_the_title( $post_id ) );
$display_name = trim( $academic_title . ' ' . $name );

if ( '' === $display_name ) {
	$display_name = $name;
}

$has_photo = has_post_thumbnail( $post_id );
?>

<div class="people-single-header<?php echo $has_photo ? ' people-single-header--has-photo' : ' people-single-header--no-photo'; ?>">
	<?php if ( $has_photo ) : ?>
		<div class="people-single-header__media">
			<?php
			echo get_the_post_thumbnail(
				$post_id,
				'large',
				[
					'class'   => 'people-single-header__image',
					'loading' => 'eager',
				]
			);
			?>
		</div>
	<?php endif; ?>

	<div class="people-single-header__content">
		<?php if ( $type_label ) : ?>
			<p class="people-single-header__type section-kicker">
				<?php echo esc_html( $type_label ); ?>
			</p>
		<?php endif; ?>

		<h1 class="people-single-header__title section-title">
			<?php echo esc_html( $display_name ); ?>
		</h1>

		<?php if ( $position ) : ?>
			<p class="people-single-header__position section-lead">
				<?php echo esc_html( $position ); ?>
			</p>
		<?php endif; ?>

		<?php if ( 'scientific' === $type_slug && $short_bio ) : ?>
			<div class="people-single-header__lead">
				<p><?php echo esc_html( $short_bio ); ?></p>
			</div>
		<?php endif; ?>
	</div>
</div>
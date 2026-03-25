<?php
defined( 'ABSPATH' ) || exit;

$post_id = isset( $args['post_id'] ) ? (int) $args['post_id'] : get_the_ID();

$card_args = wp_parse_args(
	$args ?? [],
	[
		'post_id'    => $post_id,
		'featured'   => false,
		'show_type'  => true,
		'cta_label'  => __( 'Zobacz profil', 'newinlife' ),
	]
);

if ( ! $post_id ) {
	return;
}

$title     = get_the_title( $post_id );
$permalink = get_permalink( $post_id );

$position = function_exists( 'get_field' ) ? get_field( 'person_position', $post_id ) : '';
$email    = function_exists( 'get_field' ) ? get_field( 'person_email', $post_id ) : '';

$type_label = '';
$terms      = get_the_terms( $post_id, 'people_type' );

if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
	$type_label = $terms[0]->name;
}
?>

<article class="people-card<?php echo $card_args['featured'] ? ' people-card--featured' : ''; ?>">
	<a class="people-card__link" href="<?php echo esc_url( $permalink ); ?>">
		<div class="people-card__media">
			<?php if ( has_post_thumbnail( $post_id ) ) : ?>
				<?php
				echo get_the_post_thumbnail(
					$post_id,
					'medium_large',
					[
						'class'   => 'people-card__image',
						'loading' => 'lazy',
					]
				);
				?>
			<?php else : ?>
				<div class="people-card__placeholder" aria-hidden="true"></div>
			<?php endif; ?>
		</div>

		<div class="people-card__body">
			<?php if ( $card_args['show_type'] && $type_label ) : ?>
				<p class="people-card__type"><?php echo esc_html( $type_label ); ?></p>
			<?php endif; ?>

			<h3 class="people-card__title"><?php echo esc_html( $title ); ?></h3>

			<?php if ( $position ) : ?>
				<p class="people-card__position"><?php echo esc_html( $position ); ?></p>
			<?php endif; ?>

			<?php if ( $email ) : ?>
				<p class="people-card__meta"><?php echo esc_html( antispambot( $email ) ); ?></p>
			<?php endif; ?>

			<span class="people-card__cta"><?php echo esc_html( $card_args['cta_label'] ); ?></span>
		</div>
	</a>
</article>
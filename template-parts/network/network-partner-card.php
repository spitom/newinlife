<?php
defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? [],
	[
		'post_id' => 0,
	]
);

$post_id = (int) $args['post_id'];

if ( ! $post_id ) {
	return;
}

$partner = inlife_get_partner_card_data( $post_id );
?>

<article class="network-card c-surface c-surface--record c-surface--interactive">
	<div class="network-card__inner">

		<div class="network-card__logo">
			<?php if ( ! empty( $partner['logo']['ID'] ) ) : ?>

				<?php
				echo wp_get_attachment_image(
					$partner['logo']['ID'],
					'medium',
					false,
					[
						'class' => 'network-card__logo-image',
						'alt'   => '',
					]
				);
				?>

			<?php else : ?>

				<span class="network-card__logo-placeholder">
					<?php echo esc_html( inlife_t( 'Partner InLife' ) ); ?>
				</span>

			<?php endif; ?>
		</div>

		<?php if ( ! empty( $partner['region_names'] ) ) : ?>
			<div class="network-card__badges">
				<?php foreach ( $partner['region_names'] as $region_name ) : ?>
					<span class="network-card__badge c-badge c-badge--soft c-badge--compact">
						<?php echo esc_html( $region_name ); ?>
					</span>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<div class="network-card__content">
			<h3 class="network-card__title">
				<a href="<?php echo esc_url( $partner['permalink'] ); ?>">
					<?php echo esc_html( $partner['title'] ); ?>
				</a>
			</h3>

			<?php if ( $partner['location'] ) : ?>
				<p class="network-card__location">
					<?php echo esc_html( $partner['location'] ); ?>
				</p>
			<?php endif; ?>
		</div>

		<a href="<?php echo esc_url( $partner['permalink'] ); ?>" class="c-readmore network-card__cta">
			<span class="c-readmore__label"><?php echo esc_html( inlife_t( 'Zobacz partnera' ) ); ?></span>
			<span class="c-readmore__icon" aria-hidden="true">→</span>
		</a>

	</div>
</article>
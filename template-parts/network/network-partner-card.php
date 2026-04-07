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

<article class="network-card">
	<div class="network-card__inner">

		<div class="network-card__main">
			<div class="network-card__head">
				<?php if ( ! empty( $partner['logo']['ID'] ) ) : ?>
					<div class="network-card__logo">
						<?php
						echo wp_get_attachment_image(
							$partner['logo']['ID'],
							'medium',
							false,
							[
								'class' => 'img-fluid',
								'alt'   => '',
							]
						);
						?>
					</div>
				<?php endif; ?>

				<div class="network-card__title-wrap">
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
			</div>

			<?php if ( $partner['short'] ) : ?>
				<p class="network-card__excerpt">
					<?php echo esc_html( $partner['short'] ); ?>
				</p>
			<?php endif; ?>
		</div>

		<div class="network-card__aside">
			<?php if ( ! empty( $partner['region_names'] ) ) : ?>
				<div class="network-card__badges">
					<?php foreach ( $partner['region_names'] as $region_name ) : ?>
						<span class="network-card__badge">
							<?php echo esc_html( $region_name ); ?>
						</span>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<?php if ( $partner['website'] ) : ?>
				<a href="<?php echo esc_url( $partner['website'] ); ?>" target="_blank" rel="noopener noreferrer" class="network-card__link">
					<?php echo esc_html( inlife_t( 'Strona www' ) ); ?>
				</a>
			<?php endif; ?>

			<a href="<?php echo esc_url( $partner['permalink'] ); ?>" class="network-card__cta">
				<?php echo esc_html( inlife_t( 'Zobacz partnera' ) ); ?>
			</a>
		</div>

	</div>
</article>
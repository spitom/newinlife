<?php
defined( 'ABSPATH' ) || exit;

$post_id   = $args['post_id'] ?? get_the_ID();
$container = $args['container'] ?? 'container';

$kicker = get_field( 'meet_kicker', $post_id );
$title  = get_field( 'meet_title', $post_id );
$intro  = get_field( 'meet_intro', $post_id );
$cards  = get_field( 'meet_cards', $post_id );
$cta    = get_field( 'meet_cta', $post_id );

$title = $title ?: inlife_t( 'Spotkaj się z nami' );

if ( empty( $title ) && empty( $cards ) ) {
	return;
}
?>

<section class="society-section society-section--meet">
	<div class="<?php echo esc_attr( $container ); ?>">
		<div class="society-section__header society-section__header--split">
			<div>
				<?php if ( $kicker ) : ?>
					<p class="society-section-kicker"><?php echo esc_html( $kicker ); ?></p>
				<?php endif; ?>

				<?php if ( $title ) : ?>
					<h2 class="society-section-title"><?php echo esc_html( $title ); ?></h2>
				<?php endif; ?>

				<?php if ( $intro ) : ?>
					<div class="society-section-intro">
						<p><?php echo esc_html( $intro ); ?></p>
					</div>
				<?php endif; ?>
			</div>

			<?php if ( ! empty( $cta['url'] ) && ! empty( $cta['title'] ) ) : ?>
				<div class="society-section__actions">
					<a
						class="btn btn-outline-primary"
						href="<?php echo esc_url( $cta['url'] ); ?>"
						<?php echo ! empty( $cta['target'] ) ? 'target="' . esc_attr( $cta['target'] ) . '"' : ''; ?>
					>
						<?php echo esc_html( $cta['title'] ); ?>
					</a>
				</div>
			<?php endif; ?>
		</div>

		<?php if ( ! empty( $cards ) && is_array( $cards ) ) : ?>
			<div class="society-cards society-cards--meet">
				<?php foreach ( $cards as $card ) : ?>
					<?php if ( empty( $card['title'] ) && empty( $card['text'] ) && empty( $card['link'] ) ) { continue; } ?>
					<article class="society-card society-card--meet">
						<div class="society-card__body">
							<?php if ( ! empty( $card['title'] ) ) : ?>
								<h3 class="society-card__title"><?php echo esc_html( $card['title'] ); ?></h3>
							<?php endif; ?>

							<?php if ( ! empty( $card['text'] ) ) : ?>
								<div class="society-card__text">
									<p><?php echo esc_html( $card['text'] ); ?></p>
								</div>
							<?php endif; ?>

							<?php if ( ! empty( $card['link']['url'] ) && ! empty( $card['link']['title'] ) ) : ?>
								<a
									class="society-card__link"
									href="<?php echo esc_url( $card['link']['url'] ); ?>"
									<?php echo ! empty( $card['link']['target'] ) ? 'target="' . esc_attr( $card['link']['target'] ) . '"' : ''; ?>
								>
									<?php echo esc_html( $card['link']['title'] ); ?>
								</a>
							<?php endif; ?>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
<?php
/**
 * Society - Meet Us
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

$post_id   = $args['post_id'] ?? get_the_ID();
$container = $args['container'] ?? ( function_exists( 'inlife_container_class' ) ? inlife_container_class() : 'container' );

$kicker = inlife_get_acf_field( 'meet_kicker', $post_id, '' );
$title  = inlife_get_acf_field( 'meet_title', $post_id, '' );
$intro  = inlife_get_acf_field( 'meet_intro', $post_id, '' );
$cards  = inlife_get_acf_field( 'meet_cards', $post_id, [] );

$title = inlife_get_acf_field(
	'meet_title',
	$post_id,
	inlife_t( 'Spotkaj się z nami' )
);

$has_cards = ! empty( $cards ) && is_array( $cards );
$has_intro = ! empty( $intro );

if ( ! $has_cards && ! $has_intro ) {
	return;
}
?>

<section class="society-section society-section--meet" aria-labelledby="society-meet-heading">
	<div class="<?php echo esc_attr( $container ); ?>">
		<div class="society-meet-layout">

			<?php
			get_template_part(
				'template-parts/components/section-header',
				null,
				[
					'kicker'   => $kicker,
					'title'    => $title,
					'lead'     => $intro,
					'title_id' => 'society-meet-heading',
					'class'    => 'society-section-header',
				]
			);
			?>

			<?php if ( $has_cards ) : ?>
				<div class="society-link-list society-link-list--meet">
					<?php foreach ( $cards as $card ) : ?>
						<?php
						$card_title = $card['title'] ?? '';
						$card_text  = $card['text'] ?? '';
						$card_link  = $card['link'] ?? null;

						$has_link = ! empty( $card_link['url'] ) && ! empty( $card_link['title'] );

						if ( '' === trim( (string) $card_title ) && '' === trim( (string) $card_text ) && ! $has_link ) {
							continue;
						}
						?>

						<article class="society-link-item society-link-item--meet">
							<?php if ( $has_link ) : ?>
								<a
									class="society-link-item__link"
									href="<?php echo esc_url( $card_link['url'] ); ?>"
									<?php echo ! empty( $card_link['target'] ) ? 'target="' . esc_attr( $card_link['target'] ) . '"' : ''; ?>
								>
							<?php else : ?>
								<div class="society-link-item__link society-link-item__link--static">
							<?php endif; ?>

								<div class="society-link-item__content">
									<span class="society-link-item__eyebrow">
										<?php echo esc_html( inlife_t( 'Wydarzenie' ) ); ?>
									</span>

									<?php if ( $card_title ) : ?>
										<h3 class="society-link-item__title">
											<?php echo esc_html( $card_title ); ?>
										</h3>
									<?php endif; ?>

									<?php if ( $card_text ) : ?>
										<p class="society-link-item__text">
											<?php echo esc_html( $card_text ); ?>
										</p>
									<?php endif; ?>
								</div>

								<?php if ( $has_link ) : ?>
									<span class="society-link-item__readmore c-readmore">
										<?php echo esc_html( $card_link['title'] ); ?>
										<span class="c-readmore__icon" aria-hidden="true">→</span>
									</span>
								<?php endif; ?>

							<?php if ( $has_link ) : ?>
								</a>
							<?php else : ?>
								</div>
							<?php endif; ?>
						</article>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

		</div>
	</div>
</section>
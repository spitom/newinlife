<?php
/**
 * Society - Meet Us
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

$post_id   = $args['post_id'] ?? get_the_ID();
$container = $args['container'] ?? ( function_exists( 'inlife_container_class' ) ? inlife_container_class() : 'container' );

$kicker = function_exists( 'get_field' ) ? get_field( 'meet_kicker', $post_id ) : '';
$title  = function_exists( 'get_field' ) ? get_field( 'meet_title', $post_id ) : '';
$intro  = function_exists( 'get_field' ) ? get_field( 'meet_intro', $post_id ) : '';
$cards  = function_exists( 'get_field' ) ? get_field( 'meet_cards', $post_id ) : [];
$cta    = function_exists( 'get_field' ) ? get_field( 'meet_cta', $post_id ) : null;

$title = $title ?: inlife_t( 'Spotkaj się z nami' );

$has_cards = ! empty( $cards ) && is_array( $cards );
$has_cta   = ! empty( $cta['url'] ) && ! empty( $cta['title'] );
$has_intro = ! empty( $intro );

if ( ! $has_cards && ! $has_cta && ! $has_intro ) {
	return;
}

ob_start();
?>
<?php if ( $has_cta ) : ?>
	<a
		class="btn btn-outline-primary"
		href="<?php echo esc_url( $cta['url'] ); ?>"
		<?php echo ! empty( $cta['target'] ) ? 'target="' . esc_attr( $cta['target'] ) . '"' : ''; ?>
	>
		<?php echo esc_html( $cta['title'] ); ?>
	</a>
<?php endif; ?>
<?php
$section_action = trim( (string) ob_get_clean() );
?>

<section class="society-section society-section--meet" aria-labelledby="society-meet-heading">
	<div class="<?php echo esc_attr( $container ); ?>">
		<?php
		get_template_part(
			'template-parts/components/section-header',
			null,
			[
				'kicker'      => $kicker,
				'title'       => $title,
				'lead'        => $intro,
				'action_html' => $section_action,
				'title_id'    => 'society-meet-heading',
				'class'       => 'society-section-header',
			]
		);
		?>

		<?php if ( $has_cards ) : ?>
			<div class="society-cards society-cards--meet c-card-grid">
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
					<article class="society-card society-card--meet c-card">
						<div class="society-card__frame c-card__frame c-card__frame--cut-tl">
							<div class="society-card__inner c-card__inner">
								<div class="society-card__body c-card__body">
									<?php if ( $card_title ) : ?>
										<h3 class="society-card__title c-card__title">
											<?php echo esc_html( $card_title ); ?>
										</h3>
									<?php endif; ?>

									<?php if ( $card_text ) : ?>
										<div class="society-card__text">
											<p><?php echo esc_html( $card_text ); ?></p>
										</div>
									<?php endif; ?>

									<?php if ( $has_link ) : ?>
										<a
											class="c-readmore"
											href="<?php echo esc_url( $card_link['url'] ); ?>"
											<?php echo ! empty( $card_link['target'] ) ? 'target="' . esc_attr( $card_link['target'] ) . '"' : ''; ?>
										>
											<?php echo esc_html( $card_link['title'] ); ?>
											<span class="c-readmore__icon" aria-hidden="true">→</span>
										</a>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
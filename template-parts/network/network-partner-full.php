<?php
defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? [],
	[
		'partner' => [],
	]
);

$partner = is_array( $args['partner'] ) ? $args['partner'] : [];

$website           = $partner['website'] ?? '';
$cooperation_link  = $partner['cooperation_link'] ?? '';
$cooperation_label = $partner['cooperation_label'] ?? '';
?>

<article class="network-partner-content network-partner-content--full">
	<div class="network-partner-content__section c-surface c-surface--panel">
		<h2 class="network-partner-content__heading">
			<?php echo esc_html( inlife_t( 'Informacje o partnerze' ) ); ?>
		</h2>

		<div class="network-partner-content__text entry-content">
			<?php the_content(); ?>
		</div>

		<?php if ( $website || $cooperation_link ) : ?>
			<div class="network-partner-content__actions">
				<?php if ( $website ) : ?>
					<a
						class="c-readmore network-partner-content__link"
						href="<?php echo esc_url( $website ); ?>"
						target="_blank"
						rel="noopener noreferrer"
					>
						<span class="c-readmore__label"><?php echo esc_html( inlife_t( 'Odwiedź stronę partnera' ) ); ?></span>
						<span class="c-readmore__icon" aria-hidden="true">→</span>
					</a>
				<?php endif; ?>

				<?php if ( $cooperation_link ) : ?>
					<a
						class="c-readmore network-partner-content__link"
						href="<?php echo esc_url( $cooperation_link ); ?>"
						target="_blank"
						rel="noopener noreferrer"
					>
						<span class="c-readmore__label"><?php echo esc_html( $cooperation_label ?: inlife_t( 'Zobacz współpracę' ) ); ?></span>
						<span class="c-readmore__icon" aria-hidden="true">→</span>
					</a>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
</article>
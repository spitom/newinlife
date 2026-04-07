<?php
defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? [],
	[
		'partner' => [],
	]
);

$partner = is_array( $args['partner'] ) ? $args['partner'] : [];

$title             = $partner['title'] ?? '';
$short_description = $partner['short_description'] ?? '';
$website           = $partner['website'] ?? '';
$cooperation_link  = $partner['cooperation_link'] ?? '';
$cooperation_label = $partner['cooperation_label'] ?? '';
?>

<article class="network-partner-content network-partner-content--light">
	<div class="network-partner-content__section">
		<h2 class="network-partner-content__heading">
			<?php echo esc_html( inlife_t( 'Informacje o partnerze' ) ); ?>
		</h2>

		<?php if ( $short_description ) : ?>
			<div class="network-partner-content__text">
				<p><?php echo esc_html( $short_description ); ?></p>
			</div>
		<?php else : ?>
			<div class="network-partner-content__text">
				<p>
					<?php
					echo esc_html(
						sprintf(
							/* translators: %s partner title */
							inlife_t( 'Profil %s zawiera podstawowe informacje kontaktowe i odnośniki do współpracy.' ),
							$title
						)
					);
					?>
				</p>
			</div>
		<?php endif; ?>

		<?php if ( $website || $cooperation_link ) : ?>
			<div class="network-partner-content__actions">
				<?php if ( $website ) : ?>
					<a
						class="btn btn-primary"
						href="<?php echo esc_url( $website ); ?>"
						target="_blank"
						rel="noopener noreferrer"
					>
						<?php echo esc_html( inlife_t( 'Odwiedź stronę partnera' ) ); ?>
					</a>
				<?php endif; ?>

				<?php if ( $cooperation_link ) : ?>
					<a
						class="btn btn-outline-primary"
						href="<?php echo esc_url( $cooperation_link ); ?>"
						target="_blank"
						rel="noopener noreferrer"
					>
						<?php echo esc_html( $cooperation_label ?: inlife_t( 'Zobacz współpracę' ) ); ?>
					</a>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
</article>
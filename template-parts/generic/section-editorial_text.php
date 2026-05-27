<?php
defined( 'ABSPATH' ) || exit;

$container = function_exists( 'inlife_container_class' ) ? inlife_container_class() : 'container';

$kicker = get_sub_field( 'section_kicker' );
$title  = get_sub_field( 'section_title' );
$text   = get_sub_field( 'section_text' );
?>

<section class="page-section generic-section generic-section--editorial-text">
	<div class="<?php echo esc_attr( $container ); ?>">
		<div class="generic-editorial">

			<?php if ( $kicker || $title ) : ?>
				<header class="section-heading generic-editorial__header">
					<?php if ( $kicker ) : ?>
						<p class="section-kicker">
							<?php echo esc_html( $kicker ); ?>
						</p>
					<?php endif; ?>

					<?php if ( $title ) : ?>
						<h2 class="section-title">
							<?php echo esc_html( $title ); ?>
						</h2>
					<?php endif; ?>
				</header>
			<?php endif; ?>

			<?php if ( $text ) : ?>
				<div class="generic-editorial__content c-editorial-content">
					<?php echo wp_kses_post( $text ); ?>
				</div>
			<?php endif; ?>

		</div>
	</div>
</section>
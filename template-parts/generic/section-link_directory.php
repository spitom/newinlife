<?php
defined( 'ABSPATH' ) || exit;

$container = function_exists( 'inlife_container_class' ) ? inlife_container_class() : 'container';

$kicker = get_sub_field( 'section_kicker' );
$title  = get_sub_field( 'section_title' );
$text   = get_sub_field( 'section_text' );
?>

<section class="page-section generic-section generic-section--link-directory">
	<div class="<?php echo esc_attr( $container ); ?>">
		<div class="generic-link-directory">

			<?php if ( $kicker || $title || $text ) : ?>
				<div class="generic-link-directory__intro">
					<?php if ( $kicker || $title ) : ?>
						<header class="section-heading generic-link-directory__header">
							<?php if ( $kicker ) : ?>
								<p class="section-kicker"><?php echo esc_html( $kicker ); ?></p>
							<?php endif; ?>

							<?php if ( $title ) : ?>
								<h2 class="section-title"><?php echo esc_html( $title ); ?></h2>
							<?php endif; ?>
						</header>
					<?php endif; ?>

					<?php if ( $text ) : ?>
						<div class="generic-link-directory__text c-editorial-content">
							<?php echo wp_kses_post( $text ); ?>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<?php if ( have_rows( 'section_links' ) ) : ?>
				<div class="c-card-grid c-card-grid--3 generic-link-directory__grid">
					<?php while ( have_rows( 'section_links' ) ) : the_row(); ?>
						<?php
						$link_title = get_sub_field( 'link_title' );
						$link_text  = get_sub_field( 'link_text' );
						$link_url   = get_sub_field( 'link_url' );

						if ( ! $link_title && ! $link_url ) {
							continue;
						}
						?>

						<article class="generic-link-card">
							<?php if ( $link_url ) : ?>
								<a class="generic-link-card__anchor" href="<?php echo esc_url( $link_url ); ?>">
							<?php else : ?>
								<div class="generic-link-card__anchor generic-link-card__anchor--static">
							<?php endif; ?>

								<?php if ( $link_title ) : ?>
									<h3 class="generic-link-card__title">
										<?php echo esc_html( $link_title ); ?>
									</h3>
								<?php endif; ?>

								<?php if ( $link_text ) : ?>
									<p class="generic-link-card__text">
										<?php echo esc_html( $link_text ); ?>
									</p>
								<?php endif; ?>

								<?php if ( $link_url ) : ?>
									<span class="generic-link-card__icon" aria-hidden="true">→</span>
								<?php endif; ?>

							<?php if ( $link_url ) : ?>
								</a>
							<?php else : ?>
								</div>
							<?php endif; ?>
						</article>

					<?php endwhile; ?>
				</div>
			<?php endif; ?>

		</div>
	</div>
</section>
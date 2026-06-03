<?php
defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

$intro_title = inlife_get_acf_field(
	'history_intro_title',
	$post_id,
	inlife_t( 'Od Centrum Agrotechnologii i Weterynarii PAN do InLife' )
);

$intro_text = inlife_get_acf_field(
	'history_intro_text',
	$post_id,
	inlife_t( 'Historia Instytutu to rozwój badań nad żywnością, zdrowiem, rozrodem i biologią zwierząt oraz stopniowe budowanie interdyscyplinarnego środowiska naukowego.' )
);
?>

<div class="about-history-landing">

	<div class="about-history-landing__intro">
		<div class="about-history-landing__intro-content">
			<div class="section-heading section-heading--left">

				<h2 id="about-history-landing-heading" class="section-title">
					<?php echo esc_html( $intro_title ); ?>
				</h2>
			</div>

			<?php if ( $intro_text ) : ?>
				<div class="c-editorial-content about-history-landing__intro-text">
					<?php echo wp_kses_post( wpautop( $intro_text ) ); ?>
				</div>
			<?php endif; ?>
		</div>

		<?php if ( function_exists( 'have_rows' ) && have_rows( 'history_intro_milestones', $post_id ) ) : ?>
            <div class="about-history-intro-timeline" aria-label="<?php echo esc_attr( inlife_t( 'Najważniejsze daty w historii Instytutu' ) ); ?>">
                <?php
                while ( have_rows( 'history_intro_milestones', $post_id ) ) :
                    the_row();

                    $milestone_year  = get_sub_field( 'milestone_year' );
                    $milestone_label = get_sub_field( 'milestone_label' );
                    ?>

                    <div class="about-history-intro-timeline__item">
                        <?php if ( $milestone_year ) : ?>
                            <p class="about-history-intro-timeline__year">
                                <?php echo esc_html( $milestone_year ); ?>
                            </p>
                        <?php endif; ?>

                        <?php if ( $milestone_label ) : ?>
                            <p class="about-history-intro-timeline__label">
                                <?php echo esc_html( $milestone_label ); ?>
                            </p>
                        <?php endif; ?>
                    </div>

                <?php endwhile; ?>
            </div>
        <?php endif; ?>
	</div>

	<?php if ( function_exists( 'have_rows' ) && have_rows( 'history_timeline', $post_id ) ) : ?>
		<div class="about-history-timeline" data-history-timeline>
			<?php
			while ( have_rows( 'history_timeline', $post_id ) ) :
				the_row();

				$event_year     = get_sub_field( 'event_year' );
				$event_title    = get_sub_field( 'event_title' );
				$event_text     = get_sub_field( 'event_text' );
				$event_image    = get_sub_field( 'event_image' );
				$event_featured = (bool) get_sub_field( 'event_featured' );

				$event_image_id = is_numeric( $event_image ) ? (int) $event_image : 0;

				$item_classes = [ 'about-history-timeline__item' ];

				if ( $event_featured ) {
					$item_classes[] = 'about-history-timeline__item--featured';
				}
				?>

				<article class="<?php echo esc_attr( implode( ' ', $item_classes ) ); ?>" data-history-timeline-item>
					<div class="about-history-timeline__marker" aria-hidden="true"></div>

					<div class="about-history-timeline__content">
						<?php if ( $event_year ) : ?>
							<p class="about-history-timeline__year">
								<?php echo esc_html( $event_year ); ?>
							</p>
						<?php endif; ?>

						<?php if ( $event_title ) : ?>
							<h3 class="about-history-timeline__title">
								<?php echo esc_html( $event_title ); ?>
							</h3>
						<?php endif; ?>

						<?php if ( $event_text ) : ?>
							<div class="c-editorial-content about-history-timeline__text">
								<?php echo wp_kses_post( wpautop( $event_text ) ); ?>
							</div>
						<?php endif; ?>

						<?php if ( $event_image_id ) : ?>
							<div class="about-history-timeline__media">
								<?php
								echo wp_get_attachment_image(
									$event_image_id,
									$event_featured ? 'large' : 'medium_large',
									false,
									[
										'class'   => 'about-history-timeline__image',
										'loading' => 'lazy',
									]
								);
								?>
							</div>
						<?php endif; ?>
					</div>
				</article>

			<?php endwhile; ?>
		</div>
	<?php endif; ?>

</div>
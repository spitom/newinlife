<?php
defined( 'ABSPATH' ) || exit;

$slides  = $args['slides'] ?? [];
$post_id = (int) ( $args['post_id'] ?? 0 );

if ( empty( $slides ) || ! is_array( $slides ) ) {
	return;
}

$slides_count = count( $slides );

$autoplay = function_exists( 'get_field' ) ? (bool) get_field( 'front_hero_autoplay', $post_id ) : false;
$interval = function_exists( 'get_field' ) ? (int) get_field( 'front_hero_interval', $post_id ) : 7000;

if ( $interval <= 0 ) {
	$interval = 7000;
}
?>

<div
	class="hero-slider js-hero-slider"
	data-autoplay="<?php echo esc_attr( $autoplay ? 'true' : 'false' ); ?>"
	data-interval="<?php echo esc_attr( $interval ); ?>"
>
	<div class="hero-slider__track js-hero-track">
		<?php foreach ( $slides as $index => $slide ) : ?>
			<?php
			$type   = $slide['slide_media_type'] ?? 'image';
			$image  = $slide['slide_image'] ?? null;
			$video  = $slide['slide_video'] ?? null;
			$poster = $slide['slide_video_poster'] ?? null;

			$title = $slide['slide_title'] ?? '';
			$text  = $slide['slide_text'] ?? '';
			$link  = $slide['slide_link'] ?? null;
            $link_mode  = $slide['slide_link_mode'] ?? 'content_cta';
            $aria_label = $slide['slide_aria_label'] ?? '';

			$image_id  = 0;
			$video_url = '';
			$poster_url = '';

			if ( is_array( $image ) && ! empty( $image['ID'] ) ) {
				$image_id = (int) $image['ID'];
			} elseif ( is_numeric( $image ) ) {
				$image_id = (int) $image;
			}

			if ( is_array( $video ) && ! empty( $video['url'] ) ) {
				$video_url = $video['url'];
			} elseif ( is_numeric( $video ) ) {
				$video_url = wp_get_attachment_url( (int) $video );
			}

			if ( is_array( $poster ) && ! empty( $poster['url'] ) ) {
				$poster_url = $poster['url'];
			} elseif ( is_numeric( $poster ) ) {
				$poster_url = wp_get_attachment_url( (int) $poster );
			}

			$is_active = 0 === $index;
			?>

			<div
				class="hero-slide<?php echo $is_active ? ' is-active' : ''; ?>"
				data-slide
				aria-hidden="<?php echo esc_attr( $is_active ? 'false' : 'true' ); ?>"
			>
				<div class="hero-slide__media">
					<?php if ( 'video' === $type && $video_url ) : ?>
						<video
							class="hero-slide__video"
							muted
							playsinline
							preload="metadata"
							<?php if ( $poster_url ) : ?>
								poster="<?php echo esc_url( $poster_url ); ?>"
							<?php endif; ?>
						>
							<source src="<?php echo esc_url( $video_url ); ?>" type="video/mp4">
						</video>
					<?php elseif ( $image_id ) : ?>
						<?php
						echo wp_get_attachment_image(
							$image_id,
							'full',
							false,
							[
								'class'   => 'hero-slide__image',
								'loading' => 0 === $index ? 'eager' : 'lazy',
								'alt'     => '',
							]
						);
						?>
					<?php endif; ?>
				</div>

                <?php if ( 'whole_slide' === $link_mode && is_array( $link ) && ! empty( $link['url'] ) ) : ?>
                    <a
                        class="hero-slide__full-link"
                        href="<?php echo esc_url( $link['url'] ); ?>"
                        aria-label="<?php echo esc_attr( $aria_label ?: $link['title'] ?: inlife_t( 'Przejdź do wyróżnionej treści' ) ); ?>"
                        <?php if ( ! empty( $link['target'] ) ) : ?>
                            target="<?php echo esc_attr( $link['target'] ); ?>"
                        <?php endif; ?>
                    ></a>
                <?php endif; ?>

				<?php if ( $title || $text || ( is_array( $link ) && ! empty( $link['url'] ) ) ) : ?>
					<div class="hero-slide__content">
						<div class="inlife-container">
							<div class="hero-slide__inner">
								<?php if ( $title ) : ?>
									<?php if ( 0 === $index ) : ?>
										<h1 class="hero-slide__title">
											<?php echo esc_html( $title ); ?>
										</h1>
									<?php else : ?>
										<h2 class="hero-slide__title">
											<?php echo esc_html( $title ); ?>
										</h2>
									<?php endif; ?>
								<?php endif; ?>

								<?php if ( $text ) : ?>
									<div class="hero-slide__text">
										<?php echo wp_kses_post( wpautop( $text ) ); ?>
									</div>
								<?php endif; ?>

								<?php if ( 'whole_slide' !== $link_mode && is_array( $link ) && ! empty( $link['url'] ) ) : ?>
									<a class="c-readmore hero-slide__cta" href="<?php echo esc_url( $link['url'] ); ?>">
										<?php echo esc_html( $link['title'] ?: inlife_t( 'Zobacz więcej' ) ); ?>
										<span class="c-readmore__icon" aria-hidden="true">→</span>
									</a>
								<?php endif; ?>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
	</div>

	<?php if ( $slides_count > 1 ) : ?>
		<button type="button" class="hero-slider__nav hero-slider__nav--prev js-prev" aria-label="<?php echo esc_attr( inlife_t( 'Poprzedni slajd' ) ); ?>">
			<span aria-hidden="true">‹</span>
		</button>

		<button type="button" class="hero-slider__nav hero-slider__nav--next js-next" aria-label="<?php echo esc_attr( inlife_t( 'Następny slajd' ) ); ?>">
			<span aria-hidden="true">›</span>
		</button>
	<?php endif; ?>

	<button
        type="button"
        class="hero-slider__toggle js-toggle"
        aria-label="<?php echo esc_attr( inlife_t( 'Zatrzymaj slider' ) ); ?>"
        aria-pressed="false"
    >
        <i class="bi bi-pause-fill hero-slider__icon hero-slider__icon--pause" aria-hidden="true"></i>
        <i class="bi bi-play-fill hero-slider__icon hero-slider__icon--play" aria-hidden="true"></i>
    </button>
</div>
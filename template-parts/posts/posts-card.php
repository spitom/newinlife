<?php
/**
 * Post card
 */

defined( 'ABSPATH' ) || exit;

$post_id        = $args['post_id'] ?? get_the_ID();
$custom_url     = isset( $args['custom_url'] ) ? (string) $args['custom_url'] : '';
$show_category  = isset( $args['show_category'] ) ? (bool) $args['show_category'] : true;
$show_format    = isset( $args['show_format'] ) ? (bool) $args['show_format'] : true;
$permalink      = $custom_url ?: get_permalink( $post_id );
$title          = get_the_title( $post_id );
$date           = get_the_date( '', $post_id );

$excerpt = function_exists( 'inlife_get_card_excerpt' )
	? inlife_get_card_excerpt( $post_id, 14 )
	: '';

$primary_category = function_exists( 'inlife_get_primary_post_category' )
	? inlife_get_primary_post_category( $post_id )
	: null;

/**
 * Format (society)
 */
$format_terms = get_the_terms( $post_id, 'society_format' );
$format_slug  = ( ! empty( $format_terms ) && ! is_wp_error( $format_terms ) )
	? $format_terms[0]->slug
	: '';

$format_badge = function_exists( 'inlife_get_society_format_badge' )
	? inlife_get_society_format_badge( $post_id )
	: '';

/**
 * Placeholder logic
 */
$audio_placeholder = ( 'posluchaj' === $format_slug );
$video_placeholder = ( 'zobacz' === $format_slug );
$show_media_icon   = in_array( $format_slug, [ 'posluchaj', 'zobacz' ], true );

/**
 * Image
 */
$card_image_id = function_exists( 'inlife_get_post_card_image_id' )
	? inlife_get_post_card_image_id( $post_id )
	: get_post_thumbnail_id( $post_id );

/**
 * Classes
 */
$card_classes = [
	'post-card',
	'c-card',
	'c-card--with-media',
];

if ( $format_slug ) {
	$card_classes[] = 'post-card--' . sanitize_html_class( $format_slug );
}
?>

<article <?php post_class( implode( ' ', $card_classes ), $post_id ); ?>>

	<div class="post-card__frame c-card__frame c-card__frame--cut-tl">
		<div class="post-card__inner c-card__inner">

			<!-- MEDIA -->
			<div class="post-card__media c-card__media">
				<a
					class="post-card__media-link c-card__media-link"
					href="<?php echo esc_url( $permalink ); ?>"
					aria-hidden="true"
					tabindex="-1"
				>

					<?php if ( $card_image_id ) : ?>

						<?php
						echo wp_get_attachment_image(
							$card_image_id,
							'large',
							false,
							[
								'class' => 'post-card__image c-card__image',
								'alt'   => '',
							]
						);
						?>

					<?php else : ?>

						<div class="post-card__placeholder c-card__placeholder<?php echo $audio_placeholder ? ' post-card__placeholder--audio' : ''; ?><?php echo $video_placeholder ? ' post-card__placeholder--video' : ''; ?>">

							<?php if ( $audio_placeholder ) : ?>

								<!-- <span class="bi bi-headphones post-card__audio-icon" aria-hidden="true"></span> -->
								<span><?php echo esc_html( inlife_t( 'Materiał audio' ) ); ?></span>

							<?php elseif ( $video_placeholder ) : ?>

								<!-- <span class="bi bi-play-circle post-card__video-icon" aria-hidden="true"></span> -->
								<span><?php echo esc_html( inlife_t( 'Materiał wideo' ) ); ?></span>

							<?php else : ?>

								<span><?php echo esc_html( inlife_t( 'Aktualność' ) ); ?></span>

							<?php endif; ?>

						</div>

					<?php endif; ?>

					<?php if ( $show_media_icon ) : ?>
						<span class="post-card__media-badge" aria-hidden="true">
							<span class="bi <?php echo esc_attr( 'posluchaj' === $format_slug ? 'bi-headphones' : 'bi-play-fill' ); ?>"></span>
						</span>
					<?php endif; ?>

				</a>
			</div>

			<!-- BODY -->
			<div class="post-card__body c-card__body">

				<?php if ( $show_category && $primary_category ) : ?>
					<div class="post-card__categories" aria-label="<?php echo esc_attr( inlife_t( 'Kategoria wpisu' ) ); ?>">
						<span class="post-card__category">
							<?php echo esc_html( $primary_category->name ); ?>
						</span>
					</div>
				<?php endif; ?>

				<?php if ( $show_format && $format_badge ) : ?>
					<div class="post-card__formats">
						<span class="post-card__format-badge">
							<?php echo esc_html( $format_badge ); ?>
						</span>
					</div>
				<?php endif; ?>

				<?php if ( $date ) : ?>
					<div class="post-card__meta">
						<span class="post-card__date">
							<?php echo esc_html( $date ); ?>
						</span>
					</div>
				<?php endif; ?>

				<h3 class="post-card__title c-card__title">
					<a class="post-card__title-link c-card__title-link" href="<?php echo esc_url( $permalink ); ?>">
						<?php echo esc_html( $title ); ?>
					</a>
				</h3>

				<?php if ( $excerpt ) : ?>
					<div class="post-card__text">
						<?php echo wp_kses_post( wpautop( $excerpt ) ); ?>
					</div>
				<?php endif; ?>

				<?php
				$tags = get_the_tags( $post_id );
				?>

				<?php if ( $tags ) : ?>
					<div class="post-card__tags">
						<?php foreach ( array_slice( $tags, 0, 3 ) as $tag ) : ?>
							<span class="post-card__tag">
								<?php echo esc_html( $tag->name ); ?>
							</span>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<a class="post-card__link c-readmore" href="<?php echo esc_url( $permalink ); ?>">
					<?php echo esc_html( inlife_t( 'Czytaj więcej' ) ); ?>
					<span class="c-readmore__icon" aria-hidden="true">→</span>
				</a>

			</div>

		</div>
	</div>

</article>
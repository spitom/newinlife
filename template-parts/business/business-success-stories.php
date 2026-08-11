<?php
/**
 * Business success stories
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

$post_id = $args['post_id'] ?? get_the_ID();

$section_kicker = inlife_get_acf_field(
	'business_success_kicker',
	$post_id,
	inlife_t( 'Nasze sukcesy' )
);

$section_title = inlife_get_acf_field(
	'business_success_title',
	$post_id,
	inlife_t( 'Wybrane wdrożenia i współprace' )
);

$section_text = inlife_get_acf_field(
	'business_success_text',
	$post_id,
	inlife_t( 'Zobacz przykłady działań realizowanych we współpracy z partnerami biznesowymi – od badań i analiz po wdrożenia i rozwój produktów.' )
);

$allowed_video_html = [
	'iframe' => [
		'src'             => true,
		'title'           => true,
		'width'           => true,
		'height'          => true,
		'frameborder'     => true,
		'allow'           => true,
		'allowfullscreen' => true,
		'loading'         => true,
		'referrerpolicy'  => true,
	],
];

$cases = [];

if ( function_exists( 'have_rows' ) && have_rows( 'business_success_cases', $post_id ) ) {
	while ( have_rows( 'business_success_cases', $post_id ) ) {
		the_row();

		$title = get_sub_field( 'title' );
		$image = get_sub_field( 'image' );
		$video = get_sub_field( 'video_embed' );
		$link  = get_sub_field( 'link' );

		$image_id = 0;

		if ( is_array( $image ) && ! empty( $image['ID'] ) ) {
			$image_id = (int) $image['ID'];
		} elseif ( is_numeric( $image ) ) {
			$image_id = (int) $image;
		}

		$video_html = '';

		if ( ! empty( $video ) ) {
			$video_html = trim( (string) $video );

			if ( false === strpos( $video_html, '<iframe' ) ) {
				$oembed = wp_oembed_get( wp_strip_all_tags( $video_html ) );

				if ( $oembed ) {
					$video_html = $oembed;
				}
			}
		}

		if ( $video_html ) {
			$video_html = inlife_normalize_youtube_embed_html( $video_html );
		}

		$url    = '';
		$target = '';

		if ( is_array( $link ) && ! empty( $link['url'] ) ) {
			$url    = $link['url'];
			$target = ! empty( $link['target'] ) ? $link['target'] : '';
		} elseif ( is_string( $link ) && ! empty( $link ) ) {
			$url = $link;
		}

		$cases[] = [
			'title'      => $title ?: '',
			'image_id'   => $image_id,
			'video_html' => $video_html,
			'url'        => $url,
			'target'     => $target,
		];
	}
}

if ( empty( $cases ) ) {
	return;
}
?>

<div class="business-success">

	<?php
	get_template_part(
		'template-parts/components/section-header',
		null,
		[
			'kicker'   => $section_kicker,
			'title'    => $section_title,
			'lead'     => $section_text,
			'title_id' => 'business-success-heading',
		]
	);
	?>

	<div class="business-success__grid c-card-grid c-card-grid--3">
		<?php foreach ( $cases as $index => $case ) : ?>
			<?php
			if ( empty( $case['title'] ) ) {
				continue;
			}
			?>

			<?php
			$has_link      = '' !== trim( (string) $case['url'] );
			$opens_new_tab = $has_link && '_blank' === (string) $case['target'];
			?>

			<article class="business-success-card">
				<div class="business-success-card__inner">

					<div class="business-success-card__media">
						<?php if ( ! empty( $case['video_html'] ) ) : ?>
							<div class="business-success-card__video">
								<?php echo wp_kses( $case['video_html'], $allowed_video_html ); ?>
							</div>
						<?php elseif ( $case['image_id'] ) : ?>
							<?php
							echo wp_get_attachment_image(
								$case['image_id'],
								'large',
								false,
								[
									'class'   => 'business-success-card__image',
									'loading' => 'lazy',
									'alt'     => '',
								]
							);
							?>
						<?php endif; ?>
					</div>

					<div class="business-success-card__footer">
						<h3 class="business-success-card__title">

							<?php if ( $has_link ) : ?>
								<a
									class="business-success-card__title-link"
									href="<?php echo esc_url( $case['url'] ); ?>"
									<?php if ( ! empty( $case['target'] ) ) : ?>
										target="<?php echo esc_attr( $case['target'] ); ?>"
									<?php endif; ?>
									<?php if ( $opens_new_tab ) : ?>
										rel="noopener noreferrer"
									<?php endif; ?>
								>
							<?php else : ?>
								<span class="business-success-card__title-link">
							<?php endif; ?>

								<span class="business-success-card__title-text">
									<?php echo esc_html( $case['title'] ); ?>
								</span>

								<?php if ( $has_link ) : ?>
									<span class="business-success-card__arrow" aria-hidden="true">→</span>
								<?php endif; ?>

								<?php if ( $opens_new_tab ) : ?>
									<span class="visually-hidden">
										<?php echo esc_html( inlife_t( '(otwiera w nowej karcie)' ) ); ?>
									</span>
								<?php endif; ?>

							<?php if ( $has_link ) : ?>
								</a>
							<?php else : ?>
								</span>
							<?php endif; ?>

						</h3>
					</div>

				</div>
			</article>
		<?php endforeach; ?>
	</div>

</div>
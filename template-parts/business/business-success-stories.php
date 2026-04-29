<?php
/**
 * Business success stories
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

$post_id = $args['post_id'] ?? get_the_ID();

/**
 * Section
 */
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

/**
 * Cases (ACF repeater)
 */
$cases = [];

if ( function_exists( 'have_rows' ) && have_rows( 'business_success_cases', $post_id ) ) {
	while ( have_rows( 'business_success_cases', $post_id ) ) {
		the_row();

		$title = get_sub_field( 'title' );
		$text  = get_sub_field( 'content' );
		$image = get_sub_field( 'image' );
		$video = get_sub_field( 'video_embed' );

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
				$oembed = wp_oembed_get( wp_strip_all_tags( $video ) );
				if ( $oembed ) {
					$video_html = $oembed;
				}
			}
		}

		$cases[] = [
			'title'      => $title ?: '',
			'text'       => $text ?: '',
			'image_id'   => $image_id,
			'video_html' => $video_html,
		];
	}
}

if ( empty( $cases ) ) {
	return;
}

$featured = $cases[0];
$others   = array_slice( $cases, 1 );

/**
 * Allow iframe
 */
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
	],
];
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

	<div class="business-success__grid">

		<?php foreach ( $cases as $index => $case ) : 

			$tone = $case['tone'] ?? '';

			// fallback jeśli nie dodasz pola w ACF
			if ( ! $tone ) {
				$tones = [ 'primary', 'green', 'orange', 'light' ];
				$tone  = $tones[ $index % count( $tones ) ];
			}
		?>

			<article class="business-success-card business-success-card--<?php echo esc_attr( $tone ); ?>">
				<a class="business-success-card__link" href="<?php echo esc_url( $case['url'] ?? '#' ); ?>">
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
								[ 'class' => 'business-success-card__image' ]
							);
							?>
						<?php endif; ?>
					</div>

					<div class="business-success-card__footer">
						<h3 class="business-success-card__title">
							<span class="business-success-card__title-text">
								<?php echo esc_html( $case['title'] ); ?>
							</span>
							<span class="business-success-card__arrow" aria-hidden="true">→</span>
						</h3>
					</div>
				</a>
			</article>

		<?php endforeach; ?>

	</div>

</div>
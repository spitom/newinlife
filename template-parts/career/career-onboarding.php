<?php
/**
 * Career onboarding
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

$section_kicker = function_exists( 'get_field' ) ? get_field( 'career_onboarding_kicker', $post_id ) : '';
$section_title  = function_exists( 'get_field' ) ? get_field( 'career_onboarding_title', $post_id ) : '';
$section_text   = function_exists( 'get_field' ) ? get_field( 'career_onboarding_text', $post_id ) : '';

$section_kicker = $section_kicker ?: inlife_t( 'Start' );
$section_title  = $section_title ?: inlife_t( 'Onboarding i przydatne wejścia' );
$section_text   = $section_text ?: inlife_t( 'Zebraliśmy najważniejsze ścieżki wejścia i zasoby dla osób rozpoczynających pracę, współpracę lub kształcenie w Instytucie.' );

$items = [
	[
		'title'       => inlife_t( 'Nowi pracownicy' ),
		'description' => inlife_t( 'Podstawowe informacje, materiały i odnośniki dla osób rozpoczynających pracę w Instytucie.' ),
		'url'         => '#',
	],
	[
		'title'       => inlife_t( 'Osoby z zagranicy' ),
		'description' => inlife_t( 'Przydatne informacje organizacyjne i formalne dla pracowników i współpracowników spoza Polski.' ),
		'url'         => '#',
	],
	[
		'title'       => inlife_t( 'Doktoranci' ),
		'description' => inlife_t( 'Zasoby i odnośniki wspierające osoby rozpoczynające ścieżkę kształcenia i pracy badawczej.' ),
		'url'         => '#',
	],
];

if ( function_exists( 'have_rows' ) && have_rows( 'career_onboarding_links', $post_id ) ) {
	$items = [];

	while ( have_rows( 'career_onboarding_links', $post_id ) ) {
		the_row();

		$link = get_sub_field( 'link' );
		$url  = '#';

		if ( is_array( $link ) && ! empty( $link['url'] ) ) {
			$url = $link['url'];
		} elseif ( is_string( $link ) && '' !== trim( $link ) ) {
			$url = $link;
		}

		$title       = get_sub_field( 'title' );
		$description = get_sub_field( 'description' );

		if ( ! $title && ! $description ) {
			continue;
		}

		$items[] = [
			'title'       => $title ?: '',
			'description' => $description ?: '',
			'url'         => $url,
		];
	}
}
?>

<div class="career-onboarding">

	<?php
	get_template_part(
		'template-parts/components/section-header',
		null,
		[
			'kicker'   => $section_kicker,
			'title'    => $section_title,
			'lead'     => $section_text,
			'title_id' => 'career-onboarding-heading',
		]
	);
	?>

	<?php if ( ! empty( $items ) ) : ?>
		<div class="career-onboarding__grid c-card-grid c-card-grid--3">
			<?php foreach ( $items as $item ) : ?>
				<article class="career-onboarding__item c-surface c-surface--panel">

					<a class="career-onboarding__link" href="<?php echo esc_url( $item['url'] ); ?>">

						<?php if ( ! empty( $item['title'] ) ) : ?>
							<h3 class="career-onboarding__title">
								<?php echo esc_html( $item['title'] ); ?>
							</h3>
						<?php endif; ?>

						<?php if ( ! empty( $item['description'] ) ) : ?>
							<p class="career-onboarding__text">
								<?php echo esc_html( $item['description'] ); ?>
							</p>
						<?php endif; ?>

						<span class="c-readmore career-onboarding__readmore">
							<span class="c-readmore__label"><?php echo esc_html( inlife_t( 'Przejdź dalej' ) ); ?></span>
							<span class="c-readmore__icon" aria-hidden="true">→</span>
						</span>

					</a>

				</article>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

</div>
<?php
/**
 * Career location promo
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

$section_kicker = function_exists( 'get_field' ) ? get_field( 'career_location_kicker', $post_id ) : '';
$section_title  = function_exists( 'get_field' ) ? get_field( 'career_location_title', $post_id ) : '';
$section_text   = function_exists( 'get_field' ) ? get_field( 'career_location_text', $post_id ) : '';
$image          = function_exists( 'get_field' ) ? get_field( 'career_location_image', $post_id ) : null;

$section_kicker = $section_kicker ?: inlife_t( 'Lokalizacja' );
$section_title  = $section_title ?: inlife_t( 'Polska / Olsztyn / InLife' );
$section_text   = $section_text ?: inlife_t( 'Olsztyn to nowoczesne miasto akademickie położone w regionie Warmii i Mazur, łączące rozwój naukowy z wyjątkowym otoczeniem przyrodniczym.' );

$image_id = 0;

if ( is_array( $image ) && ! empty( $image['ID'] ) ) {
	$image_id = (int) $image['ID'];
} elseif ( is_numeric( $image ) ) {
	$image_id = (int) $image;
}

$items = [
	[
		'title' => inlife_t( 'Miasto nauki' ),
		'text'  => inlife_t( 'Olsztyn jest ważnym ośrodkiem akademickim i kulturalnym regionu.' ),
		'url'   => 'https://visit.olsztyn.eu',
	],
	[
		'title' => inlife_t( 'Miasto jezior' ),
		'text'  => inlife_t( 'Jeziora, lasy i tereny zielone tworzą wyjątkowe warunki do życia i pracy.' ),
		'url'   => 'https://visit.olsztyn.eu',
	],
	[
		'title' => inlife_t( 'Kultura i historia' ),
		'text'  => inlife_t( 'Miasto łączy dziedzictwo historyczne z nowoczesną przestrzenią miejską.' ),
		'url'   => 'https://visit.olsztyn.eu',
	],
];

if ( function_exists( 'have_rows' ) && have_rows( 'career_location_items', $post_id ) ) {
	$items = [];

	while ( have_rows( 'career_location_items', $post_id ) ) {
		the_row();

		$title = get_sub_field( 'title' );
		$text  = get_sub_field( 'text' );
		$link  = get_sub_field( 'link' );

		$url = '#';

		if ( is_array( $link ) && ! empty( $link['url'] ) ) {
			$url = $link['url'];
		} elseif ( is_string( $link ) && '' !== trim( $link ) ) {
			$url = $link;
		}

		if ( ! $title && ! $text ) {
			continue;
		}

		$items[] = [
			'title' => $title ?: '',
			'text'  => $text ?: '',
			'url'   => $url,
		];
	}
}
?>

<div class="career-location career-location--featured">

	<?php if ( $image_id ) : ?>
		<div class="career-location__media" aria-hidden="true">
			<?php
			echo wp_get_attachment_image(
				$image_id,
				'large',
				false,
				[
					'class'   => 'career-location__image',
					'loading' => 'lazy',
				]
			);
			?>
		</div>
	<?php endif; ?>

	<div class="career-location__content">
		<p class="career-location__kicker">
			<?php echo esc_html( $section_kicker ); ?>
		</p>

		<h2 id="career-location-heading" class="career-location__title">
			<?php echo esc_html( $section_title ); ?>
		</h2>

		<?php if ( $section_text ) : ?>
			<div class="career-location__text">
				<?php echo wp_kses_post( wpautop( $section_text ) ); ?>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $items ) ) : ?>
			<div class="career-location__links">
				<?php foreach ( $items as $item ) : ?>
					<?php if ( empty( $item['title'] ) ) : ?>
						<?php continue; ?>
					<?php endif; ?>

					<a class="c-readmore career-location__readmore" href="<?php echo esc_url( $item['url'] ); ?>">
						<span class="c-readmore__label">
							<?php echo esc_html( $item['title'] ); ?>
						</span>
						<span class="c-readmore__icon" aria-hidden="true">→</span>
					</a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>

</div>
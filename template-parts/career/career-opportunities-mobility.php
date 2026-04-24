<?php
/**
 * Career opportunities - mobility support
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

$section_kicker = function_exists( 'get_field' ) ? get_field( 'career_mobility_kicker', $post_id ) : '';
$section_title  = function_exists( 'get_field' ) ? get_field( 'career_mobility_title', $post_id ) : '';
$section_text   = function_exists( 'get_field' ) ? get_field( 'career_mobility_text', $post_id ) : '';

$section_kicker = $section_kicker ?: inlife_t( 'Rozwój' );
$section_title  = $section_title ?: inlife_t( 'Wsparcie mobilności zawodowej' );
$section_text   = $section_text ?: inlife_t( 'Zebrane w jednym miejscu przydatne serwisy i źródła informacji wspierające rozwój zawodowy, mobilność międzynarodową i formalności związane z pracą oraz edukacją w Europie.' );

$items = [
	[
		'title' => 'EURES',
		'text'  => 'Europejski portal mobilności zawodowej i ofert pracy.',
		'url'   => 'https://eures.europa.eu/',
	],
	[
		'title' => 'Europass',
		'text'  => 'Narzędzia do tworzenia CV, prezentowania kwalifikacji i planowania rozwoju.',
		'url'   => 'https://europass.europa.eu/',
	],
	[
		'title' => 'Your Europe',
		'text'  => 'Informacje o pracy, życiu i formalnościach w krajach UE.',
		'url'   => 'https://europa.eu/youreurope/',
	],
	[
		'title' => 'Youth Portal',
		'text'  => 'Europejski portal dla młodych osób szukających programów i możliwości rozwoju.',
		'url'   => 'https://europa.eu/youth/',
	],
	[
		'title' => 'Eurodesk',
		'text'  => 'Informacje o edukacji, mobilności i programach międzynarodowych.',
		'url'   => 'https://www.eurodesk.pl/',
	],
	[
		'title' => 'ENIC-NARIC',
		'text'  => 'Informacje o uznawalności dyplomów i kwalifikacji akademickich.',
		'url'   => 'https://www.enic-naric.net/',
	],
	[
		'title' => 'SOLVIT',
		'text'  => 'Wsparcie w rozwiązywaniu problemów związanych z prawami na rynku UE.',
		'url'   => 'https://ec.europa.eu/solvit/',
	],
];

if ( function_exists( 'have_rows' ) && have_rows( 'career_mobility_links', $post_id ) ) {
	$items = [];

	while ( have_rows( 'career_mobility_links', $post_id ) ) {
		the_row();

		$link = get_sub_field( 'link' );
		$url  = '#';

		if ( is_array( $link ) && ! empty( $link['url'] ) ) {
			$url = $link['url'];
		} elseif ( is_string( $link ) && ! empty( $link ) ) {
			$url = $link;
		}

		$items[] = [
			'title' => get_sub_field( 'title' ) ?: '',
			'text'  => get_sub_field( 'description' ) ?: '',
			'url'   => $url,
		];
	}
}

get_template_part(
	'template-parts/components/section-header',
	null,
	[
		'kicker'   => $section_kicker,
		'title'    => $section_title,
		'lead'     => $section_text,
		'title_id' => 'career-mobility-heading',
	]
);
?>

<div class="career-opportunities-mobility">
	<?php if ( ! empty( $items ) ) : ?>
		<div class="career-op-list">
			<?php foreach ( $items as $item ) : ?>
				<article class="career-op-card career-op-card--mobility">
					<a
						class="career-op-card__link"
						href="<?php echo esc_url( $item['url'] ); ?>"
						target="_blank"
						rel="noopener noreferrer"
					>
						<h3 class="career-op-card__title"><?php echo esc_html( $item['title'] ); ?></h3>

						<?php if ( ! empty( $item['text'] ) ) : ?>
							<p class="career-op-card__meta">
								<?php echo esc_html( $item['text'] ); ?>
							</p>
						<?php endif; ?>

						<span class="c-readmore career-op-card__readmore">
							<span class="c-readmore__label">
								<?php echo esc_html( inlife_t( 'Przejdź do serwisu' ) ); ?>
							</span>
							<span class="c-readmore__icon" aria-hidden="true">→</span>
						</span>
					</a>
				</article>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>
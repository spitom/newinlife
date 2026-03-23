<?php
/**
 * Career opportunities - mobility support
 *
 * @package UnderStrap
 */

defined('ABSPATH') || exit;

$post_id = get_the_ID();

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


if (function_exists('have_rows') && have_rows('career_mobility_links', $post_id)) {
	$items = [];

	while (have_rows('career_mobility_links', $post_id)) {
		the_row();

		$link = get_sub_field('link');
		$url  = '#';

		if (is_array($link) && !empty($link['url'])) {
			$url = $link['url'];
		} elseif (is_string($link) && !empty($link)) {
			$url = $link;
		}

		$items[] = [
			'title' => get_sub_field('title') ?: '',
			'text'  => get_sub_field('description') ?: '',
			'url'   => $url,
		];
	}
}
?>

<div class="career-op-section">
	<div class="row g-4 align-items-end career-section-head">
		<div class="col-lg-8">
			<div class="section-heading mb-0">
				<p class="section-kicker">Rozwój</p>
				<h2 id="career-mobility-heading" class="section-title">Wsparcie mobilności zawodowej</h2>
			</div>

			<p class="section-lead mt-3 mb-0">
				Zebrane w jednym miejscu przydatne serwisy i źródła informacji wspierające rozwój zawodowy, mobilność międzynarodową i formalności związane z pracą oraz edukacją w Europie.
			</p>
		</div>
	</div>

	<?php if (!empty($items)) : ?>
		<div class="career-op-list">
			<?php foreach ($items as $item) : ?>
				<article class="career-op-card career-op-card--mobility">
					<a
						class="career-op-card__link"
						href="<?php echo esc_url($item['url']); ?>"
						target="_blank"
						rel="noopener noreferrer"
					>
						<h3 class="career-op-card__title"><?php echo esc_html($item['title']); ?></h3>

						<?php if (!empty($item['text'])) : ?>
							<p class="career-op-card__meta">
								<?php echo esc_html($item['text']); ?>
							</p>
						<?php endif; ?>

						<span class="career-op-card__cta">Przejdź do serwisu</span>
					</a>
				</article>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>
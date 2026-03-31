<?php
defined('ABSPATH') || exit;

$research_links = [
	[
		'kicker' => 'Struktura',
		'title'  => 'Zespoły',
		'url'    => 'http://localhost/newinlife/zespoly/',
	],
	[
		'kicker' => 'Infrastruktura',
		'title'  => 'Laboratoria',
		'url'    => 'http://localhost/newinlife/laboratoria/',
	],
	[
		'kicker' => 'Kierunki badań',
		'title'  => 'Obszary badań',
		'url'    => '#',
	],
	[
		'kicker' => 'Finansowanie',
		'title'  => 'Projekty',
		'url'    => 'http://localhost/newinlife/projekty/',
	],
	[
		'kicker' => 'Dorobek naukowy',
		'title'  => 'Publikacje',
		'url'    => '#',
	],
	[
		'kicker' => 'Dodatkowe treści',
		'title'  => 'Wydawnictwa',
		'url'    => '#',
	],
	[
		'kicker' => 'Wiedza i spotkania',
		'title'  => 'Seminaria',
		'url'    => '#',
	],
];
?>

<div class="research-navigation">
	<!-- <div class="research-navigation__top">
		<div class="section-heading mb-0">
			<p class="section-kicker">Struktura sekcji</p>
			<h2 id="research-navigation-heading" class="section-title">Przejdź do wybranego obszaru</h2>
		</div>
	</div> -->

	<div class="row g-4 research-navigation__grid">
		<?php foreach ($research_links as $index => $item) : ?>
			<div class="col-12 col-md-6 col-xl-4">
				<article class="research-nav-card h-100">
					<div class="research-nav-card__inner">
						<div class="research-nav-card__body">
							<div class="research-nav-card__meta">
								<p class="research-nav-card__kicker">
									<?php echo esc_html($item['kicker']); ?>
								</p>

								<span class="research-nav-card__index" aria-hidden="true">
									<?php echo esc_html(str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)); ?>
								</span>
							</div>

							<h3 class="research-nav-card__title">
								<?php echo esc_html($item['title']); ?>
							</h3>

							<div class="research-nav-card__footer">
								<a class="research-nav-card__link" href="<?php echo esc_url($item['url']); ?>">
									Przejdź dalej
									<span class="visually-hidden">: <?php echo esc_html($item['title']); ?></span>
								</a>
							</div>
						</div>
					</div>
				</article>
			</div>
		<?php endforeach; ?>
	</div>
</div>
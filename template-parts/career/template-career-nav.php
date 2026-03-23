<?php
defined('ABSPATH') || exit;

$nav_items = [
	[
		'id'    => 'konkursy-naukowe',
		'label' => 'Konkursy naukowe',
	],
	[
		'id'    => 'ogloszenia-o-prace',
		'label' => 'Ogłoszenia o pracę',
	],
	[
		'id'    => 'wyniki-konkursow',
		'label' => 'Wyniki konkursów',
	],
	[
		'id'    => 'ogloszenia-archiwalne',
		'label' => 'Ogłoszenia archiwalne',
	],
	[
		'id'    => 'mobilnosc',
		'label' => 'Wsparcie mobilności',
	],
];
?>

<nav class="career-op-nav" aria-label="Sekcje ofert i konkursów">
	<div class="career-op-nav__scroll" role="tablist" aria-orientation="horizontal">
		<?php foreach ($nav_items as $index => $item) : ?>
			<a
				class="career-op-nav__link<?php echo 0 === $index ? ' is-active' : ''; ?>"
				href="#<?php echo esc_attr($item['id']); ?>"
				role="tab"
				aria-selected="<?php echo 0 === $index ? 'true' : 'false'; ?>"
				data-section-target="<?php echo esc_attr($item['id']); ?>"
			>
				<?php echo esc_html($item['label']); ?>
			</a>
		<?php endforeach; ?>
	</div>
</nav>
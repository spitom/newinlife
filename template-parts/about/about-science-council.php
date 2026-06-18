<?php
defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

$title = inlife_get_acf_field(
	'about_science_council_title',
	$post_id,
	inlife_t( 'Rada Naukowa' )
);

$text = inlife_get_acf_field(
	'about_science_council_text',
	$post_id,
	inlife_t( 'Rada Naukowa opiniuje i wspiera kierunki rozwoju naukowego Instytutu. Na stronie znajdują się informacje o kadencji, prezydium, komisjach oraz składzie Rady.' )
);

$url   = '';
$label = inlife_t( 'Zobacz skład Rady Naukowej' );

/**
 * Find Science Council page by assigned page template.
 */
$science_council_pages = get_pages(
	[
		'post_status'  => 'publish',
		'number'       => 1,
		'meta_key'     => '_wp_page_template',
		'meta_value'   => 'page-templates/template-about-science-council.php',
		'hierarchical' => false,
	]
);

if ( ! empty( $science_council_pages ) && $science_council_pages[0] instanceof WP_Post ) {
	$url = get_permalink( $science_council_pages[0] );
}

/**
 * Fallback by expected page path.
 */
if ( ! $url ) {
	$science_council_page = get_page_by_path( 'o-nas/rada-naukowa' );

	if ( $science_council_page instanceof WP_Post ) {
		$url = get_permalink( $science_council_page );
	}
}

$base_url = $url ? strtok( $url, '#' ) : '';

$items = [
	[
		'label'  => inlife_t( 'Kadencja 2023–2026' ),
		'anchor' => 'kadencja',
	],
	[
		'label'  => inlife_t( 'Prezydium Rady' ),
		'anchor' => 'prezydium',
	],
	[
		'label'  => inlife_t( 'Komisje Rady' ),
		'anchor' => 'komisje',
	],
	[
		'label'  => inlife_t( 'Skład Rady Naukowej' ),
		'anchor' => 'sklad-rady',
	],
];

?>

<div class="about-science-council">

	<div class="about-science-council__content">
		<p class="about-science-council__kicker">
			<?php echo esc_html( inlife_t( 'Organ naukowy' ) ); ?>
		</p>

		<h2 id="about-science-council-heading" class="about-science-council__title">
			<?php echo esc_html( $title ); ?>
		</h2>

		<?php if ( $text ) : ?>
			<p class="about-science-council__text">
				<?php echo esc_html( $text ); ?>
			</p>
		<?php endif; ?>

		<?php if ( $url ) : ?>
			<a class="c-readmore about-science-council__readmore" href="<?php echo esc_url( $url ); ?>">
				<?php echo esc_html( $label ); ?>
				<span class="c-readmore__icon" aria-hidden="true">→</span>
			</a>
		<?php endif; ?>
	</div>

	<div class="about-science-council__list" aria-label="<?php echo esc_attr( inlife_t( 'Zakres informacji' ) ); ?>">
		<?php foreach ( $items as $item ) : ?>
			<?php
			$item_url = $base_url && ! empty( $item['anchor'] )
				? trailingslashit( $base_url ) . '#' . $item['anchor']
				: $base_url;
			?>

			<?php if ( $item_url ) : ?>
				<a class="about-science-council__item" href="<?php echo esc_url( $item_url ); ?>">
					<span><?php echo esc_html( $item['label'] ); ?></span>
					<span aria-hidden="true">→</span>
				</a>
			<?php else : ?>
				<div class="about-science-council__item">
					<span><?php echo esc_html( $item['label'] ); ?></span>
					<span aria-hidden="true">→</span>
				</div>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>

</div>
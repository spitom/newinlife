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

$link = inlife_get_acf_field( 'about_science_council_link', $post_id, null );

$url   = is_array( $link ) && ! empty( $link['url'] ) ? $link['url'] : '';
$label = is_array( $link ) && ! empty( $link['title'] ) ? $link['title'] : inlife_t( 'Zobacz skład Rady Naukowej' );

$items = [
	inlife_t( 'Kadencja 2023–2026' ),
	inlife_t( 'Prezydium Rady' ),
	inlife_t( 'Komisje Rady' ),
	inlife_t( 'Skład Rady Naukowej' ),
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
			<div class="about-science-council__item">
				<span><?php echo esc_html( $item ); ?></span>
				<span aria-hidden="true">→</span>
			</div>
		<?php endforeach; ?>
	</div>

</div>
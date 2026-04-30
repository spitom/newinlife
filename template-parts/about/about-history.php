<?php
defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

$title = inlife_get_acf_field(
	'about_history_title',
	$post_id,
	inlife_t( 'Historia Instytutu' )
);

$text = inlife_get_acf_field(
	'about_history_text',
	$post_id,
	inlife_t( 'Zobacz kluczowe etapy rozwoju Instytutu oraz najważniejsze wydarzenia, które ukształtowały naszą działalność naukową.' )
);

$link = inlife_get_acf_field( 'about_history_link', $post_id, null );

$url   = is_array( $link ) && ! empty( $link['url'] ) ? $link['url'] : '';
$label = is_array( $link ) && ! empty( $link['title'] ) ? $link['title'] : inlife_t( 'Zobacz historię Instytutu' );

$items = [];

if ( function_exists( 'have_rows' ) && have_rows( 'about_history_items', $post_id ) ) {
	while ( have_rows( 'about_history_items', $post_id ) ) {
		the_row();

		$year  = get_sub_field( 'year' );
		$label_item = get_sub_field( 'label' );

		if ( $year || $label_item ) {
			$items[] = [
				'year'  => $year,
				'label' => $label_item,
			];
		}
	}
}

if ( empty( $items ) ) {
	$items = [
		[
			'year'  => '1988',
			'label' => inlife_t( 'Powstanie Instytutu jako jednostki Polskiej Akademii Nauk.' ),
		],
		[
			'year'  => '2000+',
			'label' => inlife_t( 'Rozwój interdyscyplinarnych badań w obszarach żywności, zdrowia i rozrodu.' ),
		],
		[
			'year'  => inlife_t( 'Dziś' ),
			'label' => inlife_t( 'Nowoczesny instytut badawczy działający w kraju i na arenie międzynarodowej.' ),
		],
	];
}
?>

<div class="about-history">

	<div class="about-history__intro">
		<p class="about-history__kicker">
			<?php echo esc_html( inlife_t( 'Dziedzictwo i rozwój' ) ); ?>
		</p>

		<h2 id="about-history-heading" class="about-history__title">
			<?php echo esc_html( $title ); ?>
		</h2>

		<?php if ( $text ) : ?>
			<p class="about-history__text">
				<?php echo esc_html( $text ); ?>
			</p>
		<?php endif; ?>

		<?php if ( $url ) : ?>
			<a class="c-readmore about-history__readmore" href="<?php echo esc_url( $url ); ?>">
				<?php echo esc_html( $label ); ?>
				<span class="c-readmore__icon" aria-hidden="true">→</span>
			</a>
		<?php endif; ?>
	</div>

	<?php if ( ! empty( $items ) ) : ?>
		<div class="about-history__timeline" aria-label="<?php echo esc_attr( inlife_t( 'Najważniejsze daty w historii Instytutu' ) ); ?>">
			<?php foreach ( $items as $item ) : ?>
				<div class="about-history__item">
					<?php if ( ! empty( $item['year'] ) ) : ?>
						<span class="about-history__year">
							<?php echo esc_html( $item['year'] ); ?>
						</span>
					<?php endif; ?>

					<?php if ( ! empty( $item['label'] ) ) : ?>
						<span class="about-history__label">
							<?php echo esc_html( $item['label'] ); ?>
						</span>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

</div>
<?php
defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

/**
 * Structure
 */
$structure_title = inlife_get_acf_field( 'about_structure_title', $post_id, inlife_t( 'Struktura organizacyjna' ) );
$structure_text  = inlife_get_acf_field( 'about_structure_text', $post_id, inlife_t( 'Poznaj strukturę Instytutu oraz jednostki administracyjne i wsparcia badań.' ) );
$structure_link  = inlife_get_acf_field( 'about_structure_link', $post_id, null );
$structure_image = inlife_get_acf_field( 'about_structure_image', $post_id, 0 );

$structure_url   = is_array( $structure_link ) && ! empty( $structure_link['url'] ) ? $structure_link['url'] : '';
$structure_label = is_array( $structure_link ) && ! empty( $structure_link['title'] ) ? $structure_link['title'] : inlife_t( 'Zobacz strukturę' );

$structure_image_id = 0;

if ( is_array( $structure_image ) && ! empty( $structure_image['ID'] ) ) {
	$structure_image_id = (int) $structure_image['ID'];
} elseif ( is_numeric( $structure_image ) ) {
	$structure_image_id = (int) $structure_image;
}

/**
 * History
 */
$history_title = inlife_get_acf_field( 'about_history_title', $post_id, inlife_t( 'Historia Instytutu' ) );
$history_text  = inlife_get_acf_field( 'about_history_text', $post_id, inlife_t( 'Zobacz kluczowe etapy rozwoju Instytutu oraz najważniejsze wydarzenia.' ) );
$history_link  = inlife_get_acf_field( 'about_history_link', $post_id, null );

$history_url   = is_array( $history_link ) && ! empty( $history_link['url'] ) ? $history_link['url'] : '';
$history_label = is_array( $history_link ) && ! empty( $history_link['title'] ) ? $history_link['title'] : inlife_t( 'Zobacz historię' );

$history_items = [];

if ( function_exists( 'have_rows' ) && have_rows( 'about_history_items', $post_id ) ) {
	while ( have_rows( 'about_history_items', $post_id ) ) {
		the_row();

		$year  = get_sub_field( 'year' );
		$label = get_sub_field( 'label' );

		if ( $year || $label ) {
			$history_items[] = [
				'year'  => $year,
				'label' => $label,
			];
		}
	}
}

if ( empty( $history_items ) ) {
	$history_items = [
		[
			'year'  => '1950',
			'label' => inlife_t( 'Powstanie jednostki' ),
		],
		[
			'year'  => '2000+',
			'label' => inlife_t( 'Rozwój badań' ),
		],
		[
			'year'  => inlife_t( 'Dziś' ),
			'label' => inlife_t( 'Nowoczesny instytut' ),
		],
	];
}

/**
 * Media
 */
$media_title = inlife_get_acf_field( 'about_media_title', $post_id, inlife_t( 'Dla mediów' ) );
$media_text  = inlife_get_acf_field( 'about_media_text', $post_id, inlife_t( 'Materiały prasowe, informacje i zasoby dla mediów oraz partnerów.' ) );
$media_link  = inlife_get_acf_field( 'about_media_link', $post_id, null );

$media_url   = is_array( $media_link ) && ! empty( $media_link['url'] ) ? $media_link['url'] : '';
$media_label = is_array( $media_link ) && ! empty( $media_link['title'] ) ? $media_link['title'] : inlife_t( 'Materiały dla mediów' );

$media_items = [];

if ( function_exists( 'have_rows' ) && have_rows( 'about_media_items', $post_id ) ) {
	while ( have_rows( 'about_media_items', $post_id ) ) {
		the_row();

		$icon  = get_sub_field( 'icon' );
		$label = get_sub_field( 'label' );

		if ( $icon || $label ) {
			$media_items[] = [
				'icon'  => $icon ?: 'file',
				'label' => $label,
			];
		}
	}
}

if ( empty( $media_items ) ) {
	$media_items = [
		[
			'icon'  => 'file',
			'label' => inlife_t( 'Informacje prasowe' ),
		],
		[
			'icon'  => 'image',
			'label' => inlife_t( 'Zdjęcia' ),
		],
		[
			'icon'  => 'download',
			'label' => inlife_t( 'Materiały do pobrania' ),
		],
	];
}

$media_icon_map = [
	'file'     => 'bi-file-earmark-text',
	'image'    => 'bi-image',
	'download' => 'bi-download',
	'logo'     => 'bi-badge-tm',
];
?>

<div class="about-links">

	<header class="about-links__header">
		<p class="about-links__kicker">
			<?php echo esc_html( inlife_t( 'Poznaj Instytut' ) ); ?>
		</p>

		<h2 id="about-links-heading" class="about-links__title">
			<?php echo esc_html( inlife_t( 'Kluczowe informacje' ) ); ?>
		</h2>
	</header>

	<div class="about-links__sections">

		<section class="about-section about-section--structure">
			<div class="about-section__content">
				<h3 class="about-section__title">
					<?php echo esc_html( $structure_title ); ?>
				</h3>

				<?php if ( $structure_text ) : ?>
					<p class="about-section__text">
						<?php echo esc_html( $structure_text ); ?>
					</p>
				<?php endif; ?>

				<?php if ( $structure_url ) : ?>
					<a class="c-readmore" href="<?php echo esc_url( $structure_url ); ?>">
						<?php echo esc_html( $structure_label ); ?>
						<span class="c-readmore__icon" aria-hidden="true">→</span>
					</a>
				<?php endif; ?>
			</div>

			<div class="about-section__media">
				<?php if ( $structure_image_id ) : ?>
					<?php
					echo wp_get_attachment_image(
						$structure_image_id,
						'large',
						false,
						[
							'class'   => 'about-section__image',
							'loading' => 'lazy',
							'alt'     => '',
						]
					);
					?>
				<?php else : ?>
					<div class="about-section__placeholder">
						<span><?php echo esc_html( inlife_t( 'Struktura' ) ); ?></span>
					</div>
				<?php endif; ?>
			</div>
		</section>

		<section class="about-section about-section--history">
			<div class="about-section__content">
				<h3 class="about-section__title">
					<?php echo esc_html( $history_title ); ?>
				</h3>

				<?php if ( $history_text ) : ?>
					<p class="about-section__text">
						<?php echo esc_html( $history_text ); ?>
					</p>
				<?php endif; ?>

				<?php if ( ! empty( $history_items ) ) : ?>
					<div class="about-timeline">
						<?php foreach ( $history_items as $item ) : ?>
							<div class="about-timeline__item">
								<span class="about-timeline__year">
									<?php echo esc_html( $item['year'] ); ?>
								</span>
								<span class="about-timeline__label">
									<?php echo esc_html( $item['label'] ); ?>
								</span>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<?php if ( $history_url ) : ?>
					<a class="c-readmore" href="<?php echo esc_url( $history_url ); ?>">
						<?php echo esc_html( $history_label ); ?>
						<span class="c-readmore__icon" aria-hidden="true">→</span>
					</a>
				<?php endif; ?>
			</div>
		</section>

		<section class="about-section about-section--media">
			<div class="about-section__content">
				<h3 class="about-section__title">
					<?php echo esc_html( $media_title ); ?>
				</h3>

				<?php if ( $media_text ) : ?>
					<p class="about-section__text">
						<?php echo esc_html( $media_text ); ?>
					</p>
				<?php endif; ?>

				<?php if ( ! empty( $media_items ) ) : ?>
					<div class="about-media-icons">
						<?php foreach ( $media_items as $item ) : ?>
							<?php
							$icon_key   = $item['icon'] ?? 'file';
							$icon_class = $media_icon_map[ $icon_key ] ?? $media_icon_map['file'];
							?>
							<span
								class="bi <?php echo esc_attr( $icon_class ); ?>"
								aria-label="<?php echo esc_attr( $item['label'] ?? '' ); ?>"
								title="<?php echo esc_attr( $item['label'] ?? '' ); ?>"
							></span>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<?php if ( $media_url ) : ?>
					<a class="c-readmore" href="<?php echo esc_url( $media_url ); ?>">
						<?php echo esc_html( $media_label ); ?>
						<span class="c-readmore__icon" aria-hidden="true">→</span>
					</a>
				<?php endif; ?>
			</div>
		</section>

	</div>

</div>
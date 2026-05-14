<?php
defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

$title = inlife_get_acf_field(
	'about_media_title',
	$post_id,
	inlife_t( 'Dla mediów' )
);

$text = inlife_get_acf_field(
	'about_media_text',
	$post_id,
	inlife_t( 'Materiały prasowe, podstawowe informacje o Instytucie oraz zasoby do wykorzystania w komunikacji medialnej.' )
);

$contact_email = inlife_get_acf_field( 'about_media_contact_email', $post_id, '' );

$items = [];

if ( function_exists( 'have_rows' ) && have_rows( 'about_media_assets', $post_id ) ) {
	while ( have_rows( 'about_media_assets', $post_id ) ) {
		the_row();

		$asset_title = get_sub_field( 'asset_title' );
		$description = get_sub_field( 'asset_description' );
		$type        = get_sub_field( 'asset_type' );
		$file        = get_sub_field( 'asset_file' );
		$url         = get_sub_field( 'asset_url' );
		$link_label  = get_sub_field( 'asset_link_label' );

		$asset_url = '';

		if ( is_array( $file ) && ! empty( $file['url'] ) ) {
			$asset_url = $file['url'];
		} elseif ( is_numeric( $file ) ) {
			$asset_url = wp_get_attachment_url( (int) $file );
		} elseif ( $url ) {
			$asset_url = $url;
		}

		if ( ! $asset_url ) {
			continue;
		}

		$items[] = [
			'title'       => $asset_title,
			'description' => $description,
			'type'        => $type,
			'url'         => $asset_url,
			'link_label'  => $link_label ?: inlife_t( 'Pobierz' ),
		];
	}
}

if ( empty( $items ) ) {
	$items = [
		[
			'label'       => inlife_t( 'Informacje o Instytucie' ),
			'description' => inlife_t( 'Krótki opis Instytutu do wykorzystania w materiałach prasowych i informacyjnych.' ),
			'file_url'    => '',
			'type'        => 'PDF',
		],
		[
			'label'       => inlife_t( 'Logotypy i identyfikacja' ),
			'description' => inlife_t( 'Podstawowe materiały identyfikacji wizualnej Instytutu.' ),
			'file_url'    => '',
			'type'        => 'ZIP',
		],
		[
			'label'       => inlife_t( 'Zdjęcia prasowe' ),
			'description' => inlife_t( 'Wybrane zdjęcia do wykorzystania w komunikacji medialnej.' ),
			'file_url'    => '',
			'type'        => 'ZIP',
		],
	];
}
?>

<div class="about-media">

	<div class="about-media__intro">
		<p class="about-media__kicker">
			<?php echo esc_html( inlife_t( 'Komunikacja' ) ); ?>
		</p>

		<h2 id="about-media-heading" class="about-media__title">
			<?php echo esc_html( $title ); ?>
		</h2>

		<?php if ( $text ) : ?>
			<p class="about-media__text">
				<?php echo esc_html( $text ); ?>
			</p>
		<?php endif; ?>

		<?php if ( $contact_email ) : ?>
			<p class="about-media__contact">
				<span><?php echo esc_html( inlife_t( 'Kontakt dla mediów:' ) ); ?></span>
				<a href="mailto:<?php echo esc_attr( $contact_email ); ?>">
					<?php echo esc_html( function_exists( 'inlife_mask_email' ) ? inlife_mask_email( $contact_email ) : str_replace( '@', ' [at] ', $contact_email ) ); ?>
				</a>
			</p>
		<?php endif; ?>
	</div>

	<?php if ( ! empty( $items ) ) : ?>
	<div class="c-card-grid c-card-grid--3 about-media__grid" aria-label="<?php echo esc_attr( inlife_t( 'Materiały dla mediów' ) ); ?>">
		<?php foreach ( $items as $item ) : ?>
			<?php
			$item_title = $item['title'] ?? '';
			$item_desc  = $item['description'] ?? '';
			$item_url   = $item['url'] ?? '';
			$item_type  = $item['type'] ?? '';
			$item_label = $item['link_label'] ?? inlife_t( 'Pobierz' );

			$card_title = $item_title ?: $item_label;
			?>

			<article class="about-media-card">
				<?php if ( $item_url ) : ?>
					<a class="about-media-card__link" href="<?php echo esc_url( $item_url ); ?>">
						<div class="about-media-card__content">
							<?php if ( $item_type ) : ?>
								<p class="about-media-card__type">
									<?php echo esc_html( $item_type ); ?>
								</p>
							<?php endif; ?>

							<?php if ( $card_title ) : ?>
								<h3 class="about-media-card__title">
									<?php echo esc_html( $card_title ); ?>
								</h3>
							<?php endif; ?>

							<?php if ( $item_desc ) : ?>
								<p class="about-media-card__text">
									<?php echo esc_html( $item_desc ); ?>
								</p>
							<?php endif; ?>
						</div>

						<span class="about-media-card__cta">
							<span class="about-media-card__cta-label">
								<?php echo esc_html( $item_label ); ?>
							</span>
							<span class="about-media-card__icon" aria-hidden="true">→</span>
						</span>
					</a>
				<?php else : ?>
					<div class="about-media-card__link about-media-card__link--static">
						<div class="about-media-card__content">
							<?php if ( $item_type ) : ?>
								<p class="about-media-card__type">
									<?php echo esc_html( $item_type ); ?>
								</p>
							<?php endif; ?>

							<?php if ( $card_title ) : ?>
								<h3 class="about-media-card__title">
									<?php echo esc_html( $card_title ); ?>
								</h3>
							<?php endif; ?>

							<?php if ( $item_desc ) : ?>
								<p class="about-media-card__text">
									<?php echo esc_html( $item_desc ); ?>
								</p>
							<?php endif; ?>
						</div>
					</div>
				<?php endif; ?>
			</article>

		<?php endforeach; ?>
	</div>
<?php endif; ?>

</div>
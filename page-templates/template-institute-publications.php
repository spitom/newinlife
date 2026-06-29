<?php
/**
 * Template Name: Badania – Wydawnictwa
 *
 * Landing page for Institute journals and publishing activity.
 *
 * @package newinlife-child
 */

defined( 'ABSPATH' ) || exit;

get_header();

$container = function_exists( 'inlife_container_class' ) ? inlife_container_class() : 'container';
$post_id   = get_the_ID();

$hero_kicker = function_exists( 'inlife_get_acf_field' )
	? inlife_get_acf_field( 'institute_publications_hero_kicker', $post_id, inlife_t( 'Badania' ) )
	: inlife_t( 'Badania' );

$hero_title = function_exists( 'inlife_get_acf_field' )
	? inlife_get_acf_field( 'institute_publications_hero_title', $post_id, get_the_title() )
	: get_the_title();

$hero_lead = function_exists( 'inlife_get_acf_field' )
	? inlife_get_acf_field( 'institute_publications_hero_lead', $post_id, inlife_t( 'Czasopisma naukowe współtworzone przez Instytut, prezentujące wyniki badań z zakresu nauki o żywności, żywienia oraz biologii rozrodu.' ) )
	: inlife_t( 'Czasopisma naukowe współtworzone przez Instytut, prezentujące wyniki badań z zakresu nauki o żywności, żywienia oraz biologii rozrodu.' );

$assets_uri = trailingslashit( get_stylesheet_directory_uri() ) . 'assets/images/';

/**
 * Fallback data.
 *
 * It remains visible until editorial ACF content is entered.
 */
$fallback_journal_cards = array(
	array(
		'slug'        => 'food',
		'title'       => 'Polish Journal of Food and Nutrition Sciences',
		'eyebrow'     => inlife_t( 'Kwartalnik naukowy' ),
		'meta'        => inlife_t( 'Wydawany w Instytucie od 1991 roku' ),
		'description' => inlife_t( 'Międzynarodowe czasopismo publikujące w języku angielskim oryginalne prace z zakresu nauki o żywności i żywieniu. Promuje osiągnięcia polskich ośrodków naukowych oraz wspiera współpracę międzynarodową.' ),
		'url'         => 'https://journal.pan.olsztyn.pl/',
		'label'       => inlife_t( 'Przejdź do czasopisma' ),
		'image'       => $assets_uri . 'polish-journal.webp',
		'image_alt'   => inlife_t( 'Okładka czasopisma Polish Journal of Food and Nutrition Sciences' ),
	),
	array(
		'slug'        => 'reproduction',
		'title'       => 'Reproductive Biology',
		'eyebrow'     => inlife_t( 'Kwartalnik naukowy' ),
		'meta'        => inlife_t( 'Współwydawane z Towarzystwem Biologii Rozrodu' ),
		'description' => inlife_t( 'Kwartalnik poświęcony badaniom z zakresu rozrodu zwierząt. Obejmuje m.in. fizjologię, endokrynologię, immunologię, biologię molekularną, embriologię, andrologię oraz rozród wspomagany.' ),
		'url'         => 'https://www.journals.elsevier.com/reproductive-biology',
		'label'       => inlife_t( 'Przejdź do czasopisma' ),
		'image'       => $assets_uri . 'reproductive-biology.webp',
		'image_alt'   => inlife_t( 'Okładka czasopisma Reproductive Biology' ),
	),
);

$fallback_topics = array(
	inlife_t( 'nauka o żywności' ),
	inlife_t( 'żywienie człowieka' ),
	inlife_t( 'fizjologia rozrodu' ),
	inlife_t( 'endokrynologia' ),
	inlife_t( 'immunologia' ),
	inlife_t( 'biologia molekularna' ),
	inlife_t( 'embriologia' ),
	inlife_t( 'andrologia' ),
	inlife_t( 'rozród wspomagany' ),
);

/**
 * Journal cards from ACF.
 */
$journal_cards = array();

if (
	function_exists( 'have_rows' ) &&
	have_rows( 'institute_publications_journals', $post_id )
) {
	while ( have_rows( 'institute_publications_journals', $post_id ) ) {
		the_row();

		$variant = sanitize_key(
			(string) get_sub_field( 'journal_variant' )
		);

		if ( ! in_array( $variant, array( 'food', 'reproduction' ), true ) ) {
			$variant = 'food';
		}

		$title = trim(
			(string) get_sub_field( 'journal_title' )
		);

		$url = esc_url_raw(
			(string) get_sub_field( 'journal_url' )
		);

		if ( '' === $title || '' === $url ) {
			continue;
		}

		$cover = get_sub_field( 'journal_cover' );

		$cover_id = is_array( $cover )
			? (int) ( $cover['ID'] ?? 0 )
			: (int) $cover;

		$image = $cover_id
			? wp_get_attachment_image_url( $cover_id, 'large' )
			: '';

		$image_alt = $cover_id
			? trim(
				(string) get_post_meta(
					$cover_id,
					'_wp_attachment_image_alt',
					true
				)
			)
			: '';

		if ( '' === $image ) {
			$image = 'food' === $variant
				? $assets_uri . 'polish-journal.webp'
				: $assets_uri . 'reproductive-biology.webp';
		}

		if ( '' === $image_alt ) {
			$image_alt = sprintf(
				inlife_t( 'Okładka czasopisma %s' ),
				$title
			);
		}

		$journal_cards[] = array(
			'slug'        => $variant,
			'title'       => $title,
			'eyebrow'     => trim(
				(string) get_sub_field( 'journal_eyebrow' )
			),
			'meta'        => trim(
				(string) get_sub_field( 'journal_meta' )
			),
			'description' => trim(
				(string) get_sub_field( 'journal_description' )
			),
			'url'         => $url,
			'label'       => inlife_t( 'Przejdź do czasopisma' ),
			'image'       => $image,
			'image_alt'   => $image_alt,
		);
	}
}

if ( empty( $journal_cards ) ) {
	$journal_cards = $fallback_journal_cards;
}

/**
 * Topic tags from ACF.
 */
$topics = array();

if (
	function_exists( 'have_rows' ) &&
	have_rows( 'institute_publications_topics', $post_id )
) {
	while ( have_rows( 'institute_publications_topics', $post_id ) ) {
		the_row();

		$topic = trim(
			(string) get_sub_field( 'topic' )
		);

		if ( '' !== $topic ) {
			$topics[] = $topic;
		}
	}
}

if ( empty( $topics ) ) {
	$topics = $fallback_topics;
}

$scientific_publications_url = home_url( '/badania/publikacje/' );
?>

<main id="main-content" class="site-main site-main--landing site-main--institute-publications">

	<section class="page-section page-section--institute-publications-hero">
		<?php
		get_template_part(
			'template-parts/patterns/pattern-page-hero',
			null,
			[
				'kicker'      => $hero_kicker,
				'title'       => $hero_title,
				'lead'        => $hero_lead,
				'breadcrumbs' => true,
				'title_id'    => 'institute-publications-heading',
			]
		);
		?>
	</section>

	<section class="page-section page-section--institute-journals" aria-label="<?php echo esc_attr( inlife_t( 'Czasopisma wydawane i współwydawane przez Instytut' ) ); ?>">
		<div class="<?php echo esc_attr( $container ); ?>">
			<div class="institute-journals-grid">
				<?php foreach ( $journal_cards as $journal ) : ?>
					<?php
					$card_class = 'institute-journal-card institute-journal-card--' . sanitize_html_class( $journal['slug'] );
					?>
					<article class="<?php echo esc_attr( $card_class ); ?>">
						<a class="institute-journal-card__anchor" href="<?php echo esc_url( $journal['url'] ); ?>" target="_blank" rel="noopener noreferrer">
							<div class="institute-journal-card__content">
								<p class="institute-journal-card__eyebrow">
									<?php echo esc_html( $journal['eyebrow'] ); ?>
								</p>

								<h2 class="institute-journal-card__title">
									<?php echo esc_html( $journal['title'] ); ?>
								</h2>

								<p class="institute-journal-card__meta">
									<?php echo esc_html( $journal['meta'] ); ?>
								</p>

								<p class="institute-journal-card__text">
									<?php echo esc_html( $journal['description'] ); ?>
								</p>

								<span class="c-readmore institute-journal-card__link">
									<?php echo esc_html( $journal['label'] ); ?>
									<span class="c-readmore__icon" aria-hidden="true">→</span>
								</span>
							</div>

							<figure class="institute-journal-card__media" aria-hidden="true">
								<img
									class="institute-journal-card__image"
									src="<?php echo esc_url( $journal['image'] ); ?>"
									alt="<?php echo esc_attr( $journal['image_alt'] ); ?>"
									loading="lazy"
								>
							</figure>
						</a>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="page-section page-section--institute-publications-topics" aria-labelledby="institute-publications-topics-heading">
		<div class="<?php echo esc_attr( $container ); ?>">
			<div class="institute-publications-topics">
				<div class="institute-publications-topics__content">
					<p class="section-kicker"><?php echo esc_html( inlife_t( 'Zakres tematyczny' ) ); ?></p>
					<h2 id="institute-publications-topics-heading" class="section-title">
						<?php echo esc_html( inlife_t( 'Obszary publikowanych badań' ) ); ?>
					</h2>
				</div>

				<ul class="institute-publications-topics__list" aria-label="<?php echo esc_attr( inlife_t( 'Obszary tematyczne czasopism' ) ); ?>">
					<?php foreach ( $topics as $topic ) : ?>
						<li><?php echo esc_html( $topic ); ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</section>

	<section class="page-section page-section--institute-publications-cta" aria-label="<?php echo esc_attr( inlife_t( 'Publikacje naukowe Instytutu' ) ); ?>">
		<div class="<?php echo esc_attr( $container ); ?>">
			<div class="institute-publications-cta-simple">
				<a class="c-readmore c-readmore--light institute-publications-cta-simple__readmore" href="<?php echo esc_url( $scientific_publications_url ); ?>">
					<?php echo esc_html( inlife_t( 'Przejdź do publikacji naukowych InLife' ) ); ?>
					<span class="c-readmore__icon" aria-hidden="true">→</span>
				</a>
			</div>
		</div>
	</section>

</main>

<?php
get_footer();

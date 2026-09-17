<?php
/**
 * Popielno — research and nature highlights.
 *
 * @package newinlife-child
 */

defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

$section_kicker = function_exists( 'inlife_get_acf_field' )
	? trim(
		(string) inlife_get_acf_field(
			'popielno_highlights_kicker',
			$post_id,
			''
		)
	)
	: '';

$section_title = function_exists( 'inlife_get_acf_field' )
	? trim(
		(string) inlife_get_acf_field(
			'popielno_highlights_title',
			$post_id,
			''
		)
	)
	: '';

if ( '' === $section_kicker ) {
	$section_kicker = inlife_t( 'Popielno z bliska' );
}

if ( '' === $section_title ) {
	$section_title = inlife_t(
		'Badania, przyroda i historia miejsca'
	);
}

$fallback_image_id = get_post_thumbnail_id( $post_id );

$acf_items = function_exists( 'get_field' )
	? get_field( 'popielno_highlights', $post_id )
	: [];

$items = [];

if ( is_array( $acf_items ) && ! empty( $acf_items ) ) {
	foreach ( $acf_items as $acf_item ) {
		$kicker = isset( $acf_item['popielno_highlight_kicker'] )
			? trim( (string) $acf_item['popielno_highlight_kicker'] )
			: '';

		$title = isset( $acf_item['popielno_highlight_title'] )
			? trim( (string) $acf_item['popielno_highlight_title'] )
			: '';

		$text = isset( $acf_item['popielno_highlight_text'] )
			? trim( (string) $acf_item['popielno_highlight_text'] )
			: '';

		$image = $acf_item['popielno_highlight_image'] ?? 0;

		if ( is_array( $image ) ) {
			$image_id = isset( $image['ID'] )
				? (int) $image['ID']
				: 0;
		} else {
			$image_id = (int) $image;
		}

		if ( '' === $title ) {
			continue;
		}

		$items[] = [
			'kicker'   => $kicker,
			'title'    => $title,
			'text'     => $text,
			'image_id' => $image_id,
		];
	}
}

if ( empty( $items ) ) {
	$items = [
		[
			'kicker'   => inlife_t( 'Konik polski' ),
			'title'    => inlife_t( 'Wyjątkowa rasa w naturalnym otoczeniu' ),
			'text'     => inlife_t(
				'Popielno jest jednym z miejsc nierozerwalnie związanych z historią i ochroną konika polskiego — jedynej rodzimej rasy konia prymitywnego. Zwierzęta można obserwować zarówno na rozległych terenach Stacji, jak i w przygotowanych zagrodach edukacyjnych.'
			),
			'image_id' => $fallback_image_id,
		],
		[
			'kicker'   => inlife_t( 'Badania' ),
			'title'    => inlife_t( 'Nauka prowadzona blisko zwierząt i przyrody' ),
			'text'     => inlife_t(
				'Od dziesięcioleci w Stacji prowadzone są badania nad zachowaniem zwierząt oraz ochroną różnorodności biologicznej. Naturalne tereny i rozległe wybiegi umożliwiają obserwację zwierząt bezpośrednio w ich środowisku.'
			),
			'image_id' => $fallback_image_id,
		],
		[
			'kicker'   => inlife_t( 'Historia' ),
			'title'    => inlife_t( 'Muzeum w XVIII-wiecznym spichlerzu' ),
			'text'     => inlife_t(
				'Na terenie Stacji znajduje się muzeum prezentujące historię hodowli konika polskiego oraz działalność naukową prowadzoną w Popielnie. Jego siedzibą jest zabytkowy, XVIII-wieczny spichlerz.'
			),
			'image_id' => $fallback_image_id,
		],
	];
}
?>

<section
	id="badania-przyroda"
	class="page-section popielno-highlights"
	aria-labelledby="popielno-highlights-heading"
>
	<div class="<?php echo esc_attr( inlife_container_class( 'content' ) ); ?>">

		<?php
		get_template_part(
			'template-parts/components/section-header',
			null,
			[
				'kicker'   => $section_kicker,
				'title'    => $section_title,
				'title_id' => 'popielno-highlights-heading',
			]
		);
		?>

		<div class="popielno-highlights__list">

        <?php foreach ( $items as $index => $item ) : ?>

            <article
                class="popielno-highlight c-section-split c-section-split--aside-wide<?php echo 1 === $index % 2 ? ' popielno-highlight--reverse' : ''; ?>"
            >
                <div class="popielno-highlight__content c-section-split__main">

                    <?php if ( '' !== $item['kicker'] ) : ?>
						<p class="popielno-highlight__kicker">
							<?php echo esc_html( $item['kicker'] ); ?>
						</p>
					<?php endif; ?>

                    <h3 class="popielno-highlight__title">
                        <?php echo esc_html( $item['title'] ); ?>
                    </h3>

                    <?php if ( '' !== $item['text'] ) : ?>
						<p class="popielno-highlight__text">
							<?php echo esc_html( $item['text'] ); ?>
						</p>
					<?php endif; ?>

                </div>

                <?php if ( ! empty( $item['image_id'] ) ) : ?>
                    <div class="popielno-highlight__media c-section-split__aside">
                        <?php
                        echo wp_get_attachment_image(
                            (int) $item['image_id'],
                            'large',
                            false,
                            [
                                'class'   => 'popielno-highlight__image',
                                'loading' => 'lazy',
                                'alt'     => '',
                            ]
                        );
                        ?>
                    </div>
                <?php endif; ?>

            </article>

        <?php endforeach; ?>

    </div>

	</div>
</section>

<?php
/**
 * Business services by labs
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

$post_id = $args['post_id'] ?? get_the_ID();

$section_kicker = inlife_get_acf_field(
	'business_services_labs_kicker',
	$post_id,
	inlife_t( 'Zaplecze laboratoryjne' )
);

$section_title = inlife_get_acf_field(
	'business_services_labs_title',
	$post_id,
	inlife_t( 'Usługi według laboratoriów' )
);

$section_text = inlife_get_acf_field(
	'business_services_labs_text',
	$post_id,
	inlife_t( 'Poznaj laboratoria i jednostki wspierające współpracę z biznesem: analizy, ekspertyzy, badania, wdrożenia oraz projekty rozwojowe.' )
);

$labs = [
	[
		'title' => 'Sensoryczne',
		'text'  => '',
		'url'   => '#',
		'badge' => 'Laboratorium',
	],
	[
		'title' => 'Mikrobiologiczne',
		'text'  => '',
		'url'   => '#',
		'badge' => 'Laboratorium',
	],
	[
		'title' => 'Spektromerii Mas',
		'text'  => '',
		'url'   => '#',
		'badge' => 'Laboratorium',
	],
	[
		'title' => 'Zwierzętarnia',
		'text'  => '',
		'url'   => '#',
		'badge' => 'Zaplecze',
	],
	[
		'title' => 'Technik Reprodukcyjnych i Biotechnologii',
		'text'  => '',
		'url'   => '#',
		'badge' => 'Laboratorium',
	],
	[
		'title' => 'Analizy Komórek',
		'text'  => '',
		'url'   => '#',
		'badge' => 'Laboratorium',
	],
	[
		'title' => 'Biologii Molekularnej',
		'text'  => '',
		'url'   => '#',
		'badge' => 'Laboratorium',
	],
	[
		'title' => 'Wirusologiczne i Mikrobiologii Molekularnej',
		'text'  => '',
		'url'   => '#',
		'badge' => 'Laboratorium',
	],
];

if ( function_exists( 'have_rows' ) && have_rows( 'business_lab_tiles', $post_id ) ) {
	$labs = [];

	while ( have_rows( 'business_lab_tiles', $post_id ) ) {
		the_row();

		$title = get_sub_field( 'title' );
		$text  = get_sub_field( 'text' );
		$link  = get_sub_field( 'link' );
		$badge = get_sub_field( 'badge' );

		$url    = '#';
		$target = '';

		if ( is_array( $link ) && ! empty( $link['url'] ) ) {
			$url    = $link['url'];
			$target = ! empty( $link['target'] ) ? $link['target'] : '';
		} elseif ( is_string( $link ) && ! empty( $link ) ) {
			$url = $link;
		}

		$labs[] = [
			'title'  => $title ?: '',
			'text'   => $text ?: '',
			'url'    => $url,
			'target' => $target,
			'badge'  => $badge ?: inlife_t( 'Laboratorium' ),
		];
	}
}
?>

<div class="business-services business-services--labs business-labs-catalog">

	<div class="business-labs-catalog__intro">
		<?php
		get_template_part(
			'template-parts/components/section-header',
			null,
			[
				'kicker'   => $section_kicker,
				'title'    => $section_title,
				'lead'     => $section_text,
				'title_id' => 'business-services-labs-heading',
			]
		);
		?>
	</div>

	<?php if ( ! empty( $labs ) ) : ?>
		<div class="business-labs-catalog__list" role="list">
			<?php foreach ( $labs as $lab ) : ?>
				<?php
				if ( empty( $lab['title'] ) ) {
					continue;
				}

				$url    = ! empty( $lab['url'] ) ? $lab['url'] : '#';
				$target = ! empty( $lab['target'] ) ? $lab['target'] : '';
				?>

				<article class="business-lab-link">
					<a
						class="business-lab-link__anchor"
						href="<?php echo esc_url( $url ); ?>"
						<?php echo $target ? 'target="' . esc_attr( $target ) . '"' : ''; ?>
					>
						<h3 class="business-lab-link__title">
							<?php echo esc_html( $lab['title'] ); ?>
						</h3>

						<?php if ( ! empty( $lab['text'] ) ) : ?>
							<p class="business-lab-link__text">
								<?php echo esc_html( $lab['text'] ); ?>
							</p>
						<?php endif; ?>

						<span class="business-lab-link__icon" aria-hidden="true">→</span>
					</a>
				</article>

			<?php endforeach; ?>
		</div>
	<?php endif; ?>

</div>
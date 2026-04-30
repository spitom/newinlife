<?php
defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

$kicker = inlife_get_acf_field(
	'about_intro_kicker',
	$post_id,
	inlife_t( 'Misja i wizja' )
);

$title = inlife_get_acf_field(
	'about_intro_title',
	$post_id,
	inlife_t( 'Tworzymy naukę, która ma znaczenie' )
);

$mission = inlife_get_acf_field(
	'about_mission_text',
	$post_id,
	inlife_t( 'Naszą misją w InLife jest pogłębianie wiedzy i tworzenie innowacyjnych rozwiązań w obszarach żywności, zdrowia i rozrodu – z myślą o ludziach, zwierzętach i środowisku. Łączymy interdyscyplinarne badania z dialogiem ze społeczeństwem, aby stawiać czoła globalnym wyzwaniom, wspierać dobrostan oraz zrównoważony rozwój.' )
);

$image = inlife_get_acf_field( 'about_intro_image', $post_id, 0 );

$image_id = 0;

if ( is_array( $image ) && ! empty( $image['ID'] ) ) {
	$image_id = (int) $image['ID'];
} elseif ( is_numeric( $image ) ) {
	$image_id = (int) $image;
}

$stats = [];

if ( function_exists( 'have_rows' ) && have_rows( 'about_intro_stats', $post_id ) ) {
	while ( have_rows( 'about_intro_stats', $post_id ) ) {
		the_row();

		$value = get_sub_field( 'value' );
		$label = get_sub_field( 'label' );

		if ( $value || $label ) {
			$stats[] = [
				'value' => $value,
				'label' => $label,
			];
		}
	}
}

if ( empty( $stats ) ) {
	$stats = [
		[
			'value' => '50+',
			'label' => inlife_t( 'lat doświadczenia naukowego' ),
		],
		[
			'value' => '3',
			'label' => inlife_t( 'kluczowe obszary działalności' ),
		],
		[
			'value' => 'PAN',
			'label' => inlife_t( 'instytut Polskiej Akademii Nauk' ),
		],
	];
}
?>

<div class="about-intro">

	<div class="about-intro__main">

		<div class="about-intro__content">
			<p class="about-intro__kicker">
				<?php echo esc_html( $kicker ); ?>
			</p>

			<h2 id="about-intro-heading" class="about-intro__title">
				<?php echo esc_html( $title ); ?>
			</h2>

			<p class="about-intro__text">
				<?php echo esc_html( $mission ); ?>
			</p>
		</div>

		<div class="about-intro__media">
			<?php if ( $image_id ) : ?>
				<?php
				echo wp_get_attachment_image(
					$image_id,
					'large',
					false,
					[
						'class'   => 'about-intro__image',
						'loading' => 'lazy',
						'alt'     => '',
					]
				);
				?>
			<?php else : ?>
				<div class="about-intro__placeholder">
					<span><?php echo esc_html( inlife_t( 'InLife' ) ); ?></span>
				</div>
			<?php endif; ?>
		</div>

	</div>

	<?php if ( ! empty( $stats ) ) : ?>
		<div class="about-intro__stats" aria-label="<?php echo esc_attr( inlife_t( 'Najważniejsze informacje o Instytucie' ) ); ?>">
			<?php foreach ( $stats as $stat ) : ?>
				<div class="about-stat">
					<?php if ( ! empty( $stat['value'] ) ) : ?>
						<p class="about-stat__value">
							<?php echo esc_html( $stat['value'] ); ?>
						</p>
					<?php endif; ?>

					<?php if ( ! empty( $stat['label'] ) ) : ?>
						<p class="about-stat__label">
							<?php echo esc_html( $stat['label'] ); ?>
						</p>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

</div>
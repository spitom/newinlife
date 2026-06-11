<?php
defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

$term = inlife_get_acf_field(
	'science_council_term',
	$post_id,
	inlife_t( 'Kadencja 2023–2026' )
);

$intro = inlife_get_acf_field(
	'science_council_intro',
	$post_id,
	''
);

$content = apply_filters(
	'the_content',
	get_post_field( 'post_content', $post_id )
);
?>

<div class="science-council-landing">

	<aside class="science-council-landing__sidebar">
		<!-- <p class="science-council-landing__kicker">
			<?php echo esc_html( inlife_t( 'Rada Naukowa' ) ); ?>
		</p> -->

		<h2 id="about-science-council-landing-heading" class="science-council-landing__title">
			<?php echo esc_html( get_the_title() ); ?>
		</h2>

		<?php if ( $term ) : ?>
			<p class="science-council-landing__term">
				<?php echo esc_html( $term ); ?>
			</p>
		<?php endif; ?>

		<?php if ( $intro ) : ?>
			<div class="science-council-landing__intro">
				<?php echo wp_kses_post( wpautop( $intro ) ); ?>
			</div>
		<?php endif; ?>

		<nav class="science-council-landing__nav" aria-label="<?php echo esc_attr( inlife_t( 'Spis treści' ) ); ?>">
			<a href="#prezydium"><?php echo esc_html( inlife_t( 'Prezydium' ) ); ?></a>
			<a href="#komisje"><?php echo esc_html( inlife_t( 'Komisje' ) ); ?></a>
			<a href="#sklad-rady"><?php echo esc_html( inlife_t( 'Skład Rady Naukowej' ) ); ?></a>
		</nav>
	</aside>

	<div class="science-council-landing__content">
        <?php if ( $content ) : ?>
            <?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
        <?php else : ?>
            <p><?php echo esc_html( inlife_t( 'Treść strony zostanie uzupełniona.' ) ); ?></p>
        <?php endif; ?>
    </div>

</div>
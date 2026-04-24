<?php
/**
 * Career entry RODO notice.
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

$rodo_page_id = 0;

$pages = get_posts(
	[
		'post_type'      => 'page',
		'post_status'    => 'publish',
		'posts_per_page' => 1,
		'meta_key'       => '_wp_page_template',
		'meta_value'     => 'page-templates/template-career-opportunities.php',
		'lang'           => function_exists( 'pll_current_language' ) ? pll_current_language( 'slug' ) : '',
	]
);

if ( ! empty( $pages ) ) {
	$rodo_page_id = (int) $pages[0]->ID;
}

$enabled = true;

if ( $rodo_page_id && function_exists( 'get_field' ) ) {
	$field_enabled = get_field( 'career_rodo_enabled', $rodo_page_id );

	if ( null !== $field_enabled ) {
		$enabled = (bool) $field_enabled;
	}
}

if ( ! $enabled ) {
	return;
}

$kicker  = '';
$title   = '';
$content = '';

if ( $rodo_page_id && function_exists( 'get_field' ) ) {
	$kicker  = get_field( 'career_rodo_kicker', $rodo_page_id );
	$title   = get_field( 'career_rodo_title', $rodo_page_id );
	$content = get_field( 'career_rodo_content', $rodo_page_id );
}

$kicker = $kicker ?: inlife_t( 'Klauzula informacyjna' );
$title  = $title ?: inlife_t( 'Informacja o przetwarzaniu danych osobowych' );

if ( ! $content ) {
	$content = inlife_t( 'Treść klauzuli RODO i zgody rekrutacyjnej będzie renderowana automatycznie na podstawie wybranego wariantu.' );
}
?>

<section class="career-entry-rodo c-surface c-surface--panel" aria-labelledby="career-entry-rodo-heading">
	<?php if ( $kicker ) : ?>
		<p class="career-entry-rodo__kicker">
			<?php echo esc_html( $kicker ); ?>
		</p>
	<?php endif; ?>

	<h2 id="career-entry-rodo-heading" class="career-entry-rodo__title">
		<?php echo esc_html( $title ); ?>
	</h2>

	<div class="career-entry-rodo__content">
		<?php echo wp_kses_post( wpautop( $content ) ); ?>
	</div>
</section>
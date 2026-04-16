<?php
/**
 * Publication item.
 *
 * @package newinlife-child
 */

defined( 'ABSPATH' ) || exit;

$publication_post = $args['publication_post'] ?? null;
$context          = $args['context'] ?? 'default';

if ( ! $publication_post instanceof WP_Post ) {
	return;
}

$post_id      = $publication_post->ID;
$citation     = get_field( 'publication_citation', $post_id );
$authors      = get_field( 'publication_authors', $post_id );
$title_full   = get_field( 'publication_title_full', $post_id );
$source       = get_field( 'publication_source', $post_id );
$doi          = get_field( 'publication_doi', $post_id );
$external_url = get_field( 'publication_external_url', $post_id );

$link_url   = '';
$link_label = '';

if ( ! empty( $external_url ) ) {
	$link_url   = $external_url;
	$link_label = ! empty( $doi )
		? 'DOI'
		: ( function_exists( 'inlife_t' ) ? inlife_t( 'Zobacz publikację' ) : __( 'Zobacz publikację', 'newinlife-child' ) );
}

$classes = array( 'publication-item' );

if ( in_array( $context, array( 'year', 'team' ), true ) ) {
	$classes[] = 'publication-item--card';
	$classes[] = 'c-surface';
	$classes[] = 'c-surface--record';
}

$fallback_parts = array_filter(
	array(
		$authors,
		$title_full,
		$source,
	)
);

$display_citation = '';

if ( ! empty( $citation ) ) {
	$display_citation = $citation;
} elseif ( ! empty( $fallback_parts ) ) {
	$display_citation = implode( '. ', $fallback_parts );
}
?>

<article class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<div class="publication-item__main">
		<?php if ( $display_citation ) : ?>
			<p class="publication-item__citation mb-0">
				<?php echo esc_html( $display_citation ); ?>
			</p>
		<?php endif; ?>
	</div>

	<?php if ( $link_url ) : ?>
		<div class="publication-item__meta">
			<a
				class="publication-item__link"
				href="<?php echo esc_url( $link_url ); ?>"
				target="_blank"
				rel="noopener noreferrer"
			>
				<?php echo esc_html( $link_label ); ?>
				<span class="visually-hidden">
					<?php
					echo esc_html(
						function_exists( 'inlife_t' )
							? inlife_t( 'otwiera się w nowej karcie' )
							: __( 'otwiera się w nowej karcie', 'newinlife-child' )
					);
					?>
				</span>
			</a>
		</div>
	<?php endif; ?>
</article>
<?php
/**
 * Publications grouped list.
 *
 * @package newinlife-child
 */

defined( 'ABSPATH' ) || exit;

$grouped_publications = $args['grouped_publications'] ?? array();
$context              = $args['context'] ?? 'global';

if ( empty( $grouped_publications ) || ! is_array( $grouped_publications ) ) {
	return;
}
?>

<div class="publications-grouped-list">
	<?php foreach ( $grouped_publications as $year => $items ) : ?>
		<section
			id="publications-year-<?php echo esc_attr( sanitize_title( $year ) ); ?>"
			class="publications-year-group"
			aria-labelledby="publications-year-heading-<?php echo esc_attr( sanitize_title( $year ) ); ?>"
		>
			<header class="publications-year-group__header">
				<h2
					id="publications-year-heading-<?php echo esc_attr( sanitize_title( $year ) ); ?>"
					class="publications-year-group__title"
				>
					<?php echo esc_html( $year ); ?>
				</h2>
			</header>

			<div class="publications-year-group__body">
				<ol class="publications-list list-unstyled mb-0">
					<?php foreach ( $items as $publication_post ) : ?>
						<li class="publications-list__item">
							<?php
							get_template_part(
								'template-parts/publications/publication',
								'item',
								array(
									'publication_post' => $publication_post,
									'context'          => $context,
								)
							);
							?>
						</li>
					<?php endforeach; ?>
				</ol>
			</div>
		</section>
	<?php endforeach; ?>
</div>
<?php
/**
 * Team publications list.
 *
 * @package newinlife-child
 */

defined( 'ABSPATH' ) || exit;

$grouped_publications = $args['grouped_publications'] ?? array();
$current_year         = $args['current_year'] ?? '';

if ( empty( $grouped_publications ) || ! is_array( $grouped_publications ) ) {
	?>
	<div class="publications-empty">
		<p class="mb-0">
			<?php
			echo esc_html(
				function_exists( 'inlife_t' )
					? inlife_t( 'Brak publikacji do wyświetlenia.' )
					: __( 'Brak publikacji do wyświetlenia.', 'newinlife-child' )
			);
			?>
		</p>
	</div>
	<?php
	return;
}
?>

<div class="team-publications-groups">
	<?php foreach ( $grouped_publications as $year => $items ) : ?>
		<section
			class="team-publications-year"
			aria-labelledby="team-publications-year-<?php echo esc_attr( sanitize_title( $year ) ); ?>"
		>
			<header class="team-publications-year__header">
				<h3
					id="team-publications-year-<?php echo esc_attr( sanitize_title( $year ) ); ?>"
					class="team-publications-year__title"
				>
					<?php echo esc_html( $year ); ?>
				</h3>
			</header>

			<div class="team-publications-year__body">
				<ol class="publications-list list-unstyled mb-0">
					<?php foreach ( $items as $publication_post ) : ?>
						<li class="publications-list__item">
							<?php
							get_template_part(
								'template-parts/publications/publication',
								'item',
								array(
									'publication_post' => $publication_post,
									'context'          => 'team',
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
<?php
defined( 'ABSPATH' ) || exit;

$publications_url = function_exists( 'get_field' ) ? get_field( 'team_publications_archive_url' ) : '';
?>

<div class="team-section-block team-section-block--publications c-surface c-surface--panel">
	<header class="section-heading">
		<h2 class="section-title"><?php echo esc_html( inlife_t( 'Publikacje' ) ); ?></h2>
	</header>

	<div class="team-publications-list">

		<?php
		get_template_part(
			'template-parts/publications/publications',
			'team-section',
			array(
				'team_id' => get_the_ID(),
			)
		);
		?>

	</div>

	<?php if ( $publications_url ) : ?>
		<div class="team-publications-list__footer">
			<a href="<?php echo esc_url( $publications_url ); ?>" class="team-inline-link c-readmore">
				<span class="c-readmore__label">
					<?php echo esc_html( inlife_t( 'Zobacz wszystkie publikacje' ) ); ?>
				</span>
				<span class="c-readmore__icon" aria-hidden="true">→</span>
			</a>
		</div>
	<?php endif; ?>
</div>
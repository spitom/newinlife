<?php
defined( 'ABSPATH' ) || exit;

$publications_url = function_exists( 'get_field' ) ? get_field( 'team_publications_archive_url' ) : '';
?>

<div class="team-section-block team-section-block--publications">
	<header class="section-heading">
		<h2 class="section-title"><?php echo esc_html( inlife_t( 'Publikacje' ) ); ?></h2>
	</header>

	<div class="team-publications-list">

		<section class="team-publications-group">
			<h3 class="team-publications-group__year">2026</h3>
			<ul class="team-publications-group__list">
				<li><?php echo esc_html( inlife_t( 'Miejsce na publikację przypisaną do zespołu.' ) ); ?></li>
				<li><?php echo esc_html( inlife_t( 'Układ sekcji przygotowany pod grupowanie po latach.' ) ); ?></li>
			</ul>
		</section>

		<section class="team-publications-group">
			<h3 class="team-publications-group__year">2025</h3>
			<ul class="team-publications-group__list">
				<li><?php echo esc_html( inlife_t( 'Docelowo lista będzie generowana automatycznie.' ) ); ?></li>
				<li><?php echo esc_html( inlife_t( 'Na tym etapie jest to makieta akceptacyjna zgodna z przyszłym wdrożeniem.' ) ); ?></li>
			</ul>
		</section>

	</div>

	<?php if ( $publications_url ) : ?>
		<div class="team-publications-list__footer">
			<a href="<?php echo esc_url( $publications_url ); ?>" class="team-inline-link">
				<?php echo esc_html( inlife_t( 'Zobacz wszystkie publikacje' ) ); ?> <span aria-hidden="true">→</span>
			</a>
		</div>
	<?php endif; ?>
</div>
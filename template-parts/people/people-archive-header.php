<?php
defined( 'ABSPATH' ) || exit;
?>

<div class="row g-4 align-items-end people-section-head">
	<div class="col-lg-8">
		<div class="section-heading mb-0">
			<p class="section-kicker">
				<?php esc_html_e( 'Ludzie', 'newinlife' ); ?>
			</p>

			<h1 class="section-title">
				<?php post_type_archive_title(); ?>
			</h1>
		</div>

		<p class="section-lead mt-3 mb-0">
			<?php esc_html_e( 'Centralny katalog pracowników instytutu z możliwością wyszukiwania i filtrowania.', 'newinlife' ); ?>
		</p>
	</div>
</div>
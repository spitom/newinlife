<?php
/**
 * Laboratories archive header.
 *
 * @package newinlife
 */

defined( 'ABSPATH' ) || exit;
?>

<section class="laboratories-archive-header section">
	<div class="container">

		<div class="row align-items-center g-5">

			<div class="col-lg-6">
				<p class="section-eyebrow">
					<?php echo esc_html( inlife_t( 'Badania' ) ); ?>
				</p>

				<h1 class="section-title">
					<?php echo esc_html( inlife_t( 'Laboratoria' ) ); ?>
				</h1>

				<p class="section-lead">
					<?php echo esc_html( inlife_t( 'Poznaj laboratoria wspierające działalność badawczą instytutu, oferujące specjalistyczne metody, analizy oraz zaplecze aparaturowe.' ) ); ?>
				</p>
			</div>

			<div class="col-lg-6">
				<div class="laboratories-archive-header__visual">
					<div class="laboratories-archive-header__visual-card"><?php esc_html_e( 'Metody', 'newinlife' ); ?></div>
					<div class="laboratories-archive-header__visual-card"><?php esc_html_e( 'Analizy', 'newinlife' ); ?></div>
					<div class="laboratories-archive-header__visual-card"><?php esc_html_e( 'Sprzęt', 'newinlife' ); ?></div>
					<div class="laboratories-archive-header__visual-card"><?php esc_html_e( 'Zespół', 'newinlife' ); ?></div>
				</div>
			</div>

		</div>

	</div>
</section>
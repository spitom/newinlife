<?php
defined( 'ABSPATH' ) || exit;
?>

<div class="lab-section-block lab-section-block--equipment">
	<header class="section-heading">
		<h2 class="section-title"><?php echo esc_html( inlife_t( 'Wyposażenie laboratorium' ) ); ?></h2>
	</header>

	<?php
	$equipment_content = function_exists( 'get_field' ) ? get_field( 'laboratory_equipment_content' ) : '';
	?>

	<?php if ( $equipment_content ) : ?>
		<div class="lab-section-block lab-section-block--equipment">
			<div class="lab-editorial-content entry-content">
				<?php echo wp_kses_post( $equipment_content ); ?>
			</div>
		</div>
	<?php endif; ?>
</div>
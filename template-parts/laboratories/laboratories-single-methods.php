<?php
defined( 'ABSPATH' ) || exit;
?>

<div class="lab-section-block lab-section-block--methods">
	<header class="section-heading">
		<h2 class="section-title"><?php echo esc_html( inlife_t( 'Oferowane metody i analizy' ) ); ?></h2>
	</header>

	<?php
	$methods_content = function_exists( 'get_field' ) ? get_field( 'laboratory_methods_content' ) : '';
	?>

	<?php if ( $methods_content ) : ?>
		<div class="lab-section-block lab-section-block--methods">
			<div class="lab-editorial-content entry-content">
				<?php echo wp_kses_post( $methods_content ); ?>
			</div>
		</div>
	<?php endif; ?>
</div>
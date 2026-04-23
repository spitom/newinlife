<?php
defined( 'ABSPATH' ) || exit;
?>

<article class="career-entry-content inlife-text">

	<?php if ( has_excerpt() ) : ?>
		<div class="career-entry-content__lead">
			<?php echo wp_kses_post( wpautop( get_the_excerpt() ) ); ?>
		</div>
	<?php endif; ?>

	<div class="career-entry-content__body">
		<?php the_content(); ?>
	</div>

</article>
<?php
/**
 * Generic editable page content.
 *
 * @package newinlife-child
 */

defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? [],
	[
		'post_id' => get_the_ID(),
	]
);

$container = function_exists( 'inlife_container_class' ) ? inlife_container_class() : 'container';
$post_id   = (int) $args['post_id'];
?>

<section class="page-section page-section--editorial-page-content" aria-labelledby="editorial-page-heading">
	<div class="<?php echo esc_attr( $container ); ?>">
		<div class="editorial-page-layout">
			<article <?php post_class( 'editorial-page-content', $post_id ); ?>>
				<div class="editorial-page-content__inner">
					<div class="editorial-page-content__body c-editorial-content">
						<?php the_content(); ?>
					</div>
				</div>
			</article>
		</div>
	</div>
</section>
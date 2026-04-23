<?php
/**
 * Society - Media
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

$post_id   = $args['post_id'] ?? get_the_ID();
$container = $args['container'] ?? ( function_exists( 'inlife_container_class' ) ? inlife_container_class() : 'container' );

$kicker = function_exists( 'get_field' ) ? get_field( 'media_kicker', $post_id ) : '';
$title  = function_exists( 'get_field' ) ? get_field( 'media_title', $post_id ) : '';
$intro  = function_exists( 'get_field' ) ? get_field( 'media_intro', $post_id ) : '';
$posts  = function_exists( 'get_field' ) ? get_field( 'media_posts', $post_id ) : [];
$cta    = function_exists( 'get_field' ) ? get_field( 'media_cta', $post_id ) : null;

$title = $title ?: inlife_t( 'Podcasty i infografiki' );

if ( empty( $posts ) || ! is_array( $posts ) ) {
	return;
}

ob_start();
?>
<?php if ( ! empty( $cta['url'] ) && ! empty( $cta['title'] ) ) : ?>
	<a
		class="btn btn-outline-primary"
		href="<?php echo esc_url( $cta['url'] ); ?>"
		<?php echo ! empty( $cta['target'] ) ? 'target="' . esc_attr( $cta['target'] ) . '"' : ''; ?>
	>
		<?php echo esc_html( $cta['title'] ); ?>
	</a>
<?php endif; ?>
<?php
$section_action = trim( (string) ob_get_clean() );
?>

<section class="society-section society-section--media" aria-labelledby="society-media-heading">
	<div class="<?php echo esc_attr( $container ); ?>">
		<?php
		get_template_part(
			'template-parts/components/section-header',
			null,
			[
				'kicker'      => $kicker,
				'title'       => $title,
				'lead'        => $intro,
				'action_html' => $section_action,
				'title_id'    => 'society-media-heading',
				'class'       => 'society-section-header',
			]
		);
		?>

		<div class="society-cards society-cards--media c-card-grid">
			<?php foreach ( $posts as $post_item ) : ?>
				<?php
				$post_id_item = $post_item instanceof WP_Post ? $post_item->ID : (int) $post_item;

				if ( ! $post_id_item ) {
					continue;
				}

				get_template_part(
					'template-parts/posts/posts-card',
					'post',
					[
						'post_id' => $post_id_item,
					]
				);
				?>
			<?php endforeach; ?>
		</div>
	</div>
</section>
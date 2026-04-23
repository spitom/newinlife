<?php
defined( 'ABSPATH' ) || exit;

$post_id   = $args['post_id'] ?? get_the_ID();
$container = $args['container'] ?? ( function_exists( 'inlife_container_class' ) ? inlife_container_class() : 'container' );

$kicker = function_exists( 'get_field' ) ? get_field( 'articles_kicker', $post_id ) : '';
$title  = function_exists( 'get_field' ) ? get_field( 'articles_title', $post_id ) : '';
$intro  = function_exists( 'get_field' ) ? get_field( 'articles_intro', $post_id ) : '';
$cta    = function_exists( 'get_field' ) ? get_field( 'articles_cta', $post_id ) : null;

$posts = function_exists( 'inlife_get_society_posts' )
	? inlife_get_society_posts( 4 )
	: [];

$title = $title ?: inlife_t( 'Materiały' );

if ( empty( $posts ) ) {
	return;
}

ob_start();
?>
<?php if ( ! empty( $cta['url'] ) && ! empty( $cta['title'] ) ) : ?>
	<a
		class="btn btn-outline-primary"
		href="<?php echo esc_url( $cta['url'] ); ?>"
	>
		<?php echo esc_html( $cta['title'] ); ?>
	</a>
<?php endif; ?>
<?php
$section_action = trim( (string) ob_get_clean() );
?>

<section class="society-section society-section--content">
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
			]
		);
		?>

		<div class="society-cards c-card-grid c-card-grid--4">
			<?php foreach ( $posts as $post_item ) : ?>
				<?php
				$post_url = add_query_arg( 'from', 'society', get_permalink( $post_item->ID ) );

				get_template_part(
					'template-parts/posts/posts',
					'card',
					[
						'post_id'       => $post_item->ID,
						'show_category' => false,
						'show_format'   => true,
						'custom_url'    => $post_url,
					]
				);
				?>
			<?php endforeach; ?>
		</div>

	</div>
</section>
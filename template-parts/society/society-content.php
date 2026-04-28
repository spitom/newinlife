<?php
/**
 * Society - Articles / Materials
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

$post_id   = $args['post_id'] ?? get_the_ID();
$container = $args['container'] ?? ( function_exists( 'inlife_container_class' ) ? inlife_container_class() : 'container' );

$kicker = inlife_get_acf_field( 'articles_kicker', $post_id, '' );
$title  = inlife_get_acf_field( 'articles_title', $post_id, '' );
$intro  = inlife_get_acf_field( 'articles_intro', $post_id, '' );
$cta    = inlife_get_acf_field( 'articles_cta', $post_id, null );

$posts = function_exists( 'inlife_get_society_posts' )
	? inlife_get_society_posts( 4 )
	: [];

$title = inlife_get_acf_field(
	'articles_title',
	$post_id,
	inlife_t( 'Artykuły' )
);

if ( empty( $posts ) ) {
	return;
}

$cta_url    = ! empty( $cta['url'] ) ? $cta['url'] : home_url( '/spoleczenstwo/artykuly/' );
$cta_title  = ! empty( $cta['title'] ) ? $cta['title'] : inlife_t( 'Zobacz wszystkie' );
$cta_target = ! empty( $cta['target'] ) ? $cta['target'] : '';

ob_start();
?>
<a
	class="c-readmore"
	href="<?php echo esc_url( $cta_url ); ?>"
	<?php echo $cta_target ? 'target="' . esc_attr( $cta_target ) . '"' : ''; ?>
>
	<?php echo esc_html( $cta_title ); ?>
	<span class="c-readmore__icon" aria-hidden="true">→</span>
</a>
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
				if ( ! $post_item instanceof WP_Post ) {
					continue;
				}

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
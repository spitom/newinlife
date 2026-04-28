<?php
/**
 * Society - Initiatives
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

$post_id   = $args['post_id'] ?? get_the_ID();
$container = $args['container'] ?? ( function_exists( 'inlife_container_class' ) ? inlife_container_class() : 'container' );

$kicker = inlife_get_acf_field( 'initiatives_kicker', $post_id, '' );
$title  = inlife_get_acf_field( 'initiatives_title', $post_id, '' );
$intro  = inlife_get_acf_field( 'initiatives_intro', $post_id, '' );
$pages  = inlife_get_acf_field( 'initiatives_pages', $post_id, [] );
$cta    = inlife_get_acf_field( 'initiatives_cta', $post_id, null );

$title = inlife_get_acf_field(
	'initiatives_title',
	$post_id,
	inlife_t( 'Projekty i inicjatywy' )
);

if ( empty( $pages ) || ! is_array( $pages ) ) {
	return;
}

ob_start();
?>
<?php if ( ! empty( $cta['url'] ) && ! empty( $cta['title'] ) ) : ?>
	<a
		class="c-readmore"
		href="<?php echo esc_url( $cta['url'] ); ?>"
		<?php echo ! empty( $cta['target'] ) ? 'target="' . esc_attr( $cta['target'] ) . '"' : ''; ?>
	>
		<?php echo esc_html( $cta['title'] ); ?>
		<span class="c-readmore__icon" aria-hidden="true">→</span>
	</a>
<?php endif; ?>
<?php
$section_action = trim( (string) ob_get_clean() );
?>

<section class="society-section society-section--initiatives" aria-labelledby="society-initiatives-heading">
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
				'title_id'    => 'society-initiatives-heading',
				'class'       => 'society-section-header',
			]
		);
		?>

		<div class="society-cards society-cards--initiatives c-card-grid">
			<?php foreach ( $pages as $page_item ) : ?>
				<?php
				$page_id = $page_item instanceof WP_Post ? $page_item->ID : (int) $page_item;

				if ( ! $page_id ) {
					continue;
				}

				get_template_part(
					'template-parts/society/components/card',
					'initiative',
					[
						'post_id' => $page_id,
					]
				);
				?>
			<?php endforeach; ?>
		</div>
	</div>
</section>
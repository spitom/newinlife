<?php
/**
 * Template Name: Society
 * Template Post Type: page
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

get_header();

$container = function_exists( 'inlife_container_class' ) ? inlife_container_class() : 'container';
$post_id   = get_the_ID();

$kicker = function_exists( 'get_field' ) ? get_field( 'hero_kicker', $post_id ) : '';
$title  = function_exists( 'get_field' ) ? get_field( 'hero_title', $post_id ) : '';
$lead   = function_exists( 'get_field' ) ? get_field( 'hero_lead', $post_id ) : '';

$primary_cta   = function_exists( 'get_field' ) ? get_field( 'hero_primary_cta', $post_id ) : null;
$secondary_cta = function_exists( 'get_field' ) ? get_field( 'hero_secondary_cta', $post_id ) : null;

$kicker = $kicker ?: inlife_t( 'Społeczeństwo' );
$title  = $title ?: get_the_title( $post_id );

ob_start();
?>

<?php if ( ! empty( $primary_cta['url'] ) && ! empty( $primary_cta['title'] ) ) : ?>
	<a
		class="btn btn-primary"
		href="<?php echo esc_url( $primary_cta['url'] ); ?>"
		<?php echo ! empty( $primary_cta['target'] ) ? 'target="' . esc_attr( $primary_cta['target'] ) . '"' : ''; ?>
	>
		<?php echo esc_html( $primary_cta['title'] ); ?>
	</a>
<?php endif; ?>

<?php if ( ! empty( $secondary_cta['url'] ) && ! empty( $secondary_cta['title'] ) ) : ?>
	<a
		class="btn btn-outline-primary"
		href="<?php echo esc_url( $secondary_cta['url'] ); ?>"
		<?php echo ! empty( $secondary_cta['target'] ) ? 'target="' . esc_attr( $secondary_cta['target'] ) . '"' : ''; ?>
	>
		<?php echo esc_html( $secondary_cta['title'] ); ?>
	</a>
<?php endif; ?>

<?php
$hero_actions = trim( (string) ob_get_clean() );

$context = [
	'post_id'   => $post_id,
	'container' => $container,
];
?>

<main id="main-content" class="site-main site-main--society">

	<section class="page-section page-section--society-hero">
		<?php
		get_template_part(
			'template-parts/patterns/pattern-page-hero',
			null,
			[
				'kicker'       => $kicker,
				'title'        => $title,
				'lead'         => $lead,
				'breadcrumbs'  => true,
				'actions_html' => $hero_actions,
			]
		);
		?>
	</section>

	<?php get_template_part( 'template-parts/society/society', 'science-for-you', $context ); ?>
	<?php get_template_part( 'template-parts/society/society', 'content', $context ); ?>
	<?php get_template_part( 'template-parts/society/society', 'initiatives', $context ); ?>
	<?php get_template_part( 'template-parts/society/society', 'meet-us', $context ); ?>
	<?php get_template_part( 'template-parts/society/society', 'schools', $context ); ?>

</main>

<?php
get_footer();
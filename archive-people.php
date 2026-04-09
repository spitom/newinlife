<?php
/**
 * Archive People
 *
 * @package newinlife
 */

defined( 'ABSPATH' ) || exit;

get_header();

$container = function_exists( 'inlife_container_class' ) ? inlife_container_class() : 'container';
?>

<main id="main-content" class="site-main site-main--people-archive">

	<section class="page-section page-section--people-archive-hero">
		<?php
		get_template_part(
			'template-parts/patterns/pattern-page-hero',
			null,
			[
				'kicker'      => inlife_t( 'Ludzie' ),
				'title'       => post_type_archive_title( '', false ),
				'lead'        => inlife_t( 'Centralny katalog pracowników instytutu z możliwością wyszukiwania i filtrowania.' ),
				'breadcrumbs' => true,
				'modifier'    => 'flush',
			]
		);
		?>
	</section>

	<section class="page-section page-section--people-archive-content">
		<div class="<?php echo esc_attr( $container ); ?>">

			<?php get_template_part( 'template-parts/people/people', 'search' ); ?>
			<?php get_template_part( 'template-parts/people/people', 'filters' ); ?>
			<?php get_template_part( 'template-parts/people/people', 'alpha-filter' ); ?>
			<?php get_template_part( 'template-parts/people/people', 'directory' ); ?>

		</div>
	</section>
</main>

<?php
get_footer();
<?php
/**
 * Single Career Entry
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

get_header();

$container = inlife_container_class();

while ( have_posts() ) :
	the_post();

	$post_id = get_the_ID();

	$type_label = function_exists( 'inlife_get_career_entry_type_label' )
		? inlife_get_career_entry_type_label( $post_id )
		: inlife_t( 'Kariera' );

	$lead = has_excerpt() ? get_the_excerpt( $post_id ) : '';

	$career_page_url  = home_url( '/kariera/' );
	$career_page_label = inlife_t( 'Kariera' );

	$opportunities_url   = home_url( '/kariera/konkursy-i-oferty-pracy/' );
	$opportunities_label = inlife_t( 'Konkursy i oferty pracy' );

	ob_start();
	?>
	<nav class="c-breadcrumbs" aria-label="<?php echo esc_attr( inlife_t( 'Okruszki' ) ); ?>">
		<ol class="c-breadcrumbs__list">
			<li class="c-breadcrumbs__item">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<?php echo esc_html( inlife_t( 'Strona główna' ) ); ?>
				</a>
			</li>
			<li class="c-breadcrumbs__item">
				<a href="<?php echo esc_url( $career_page_url ); ?>">
					<?php echo esc_html( $career_page_label ); ?>
				</a>
			</li>
			<li class="c-breadcrumbs__item">
				<a href="<?php echo esc_url( $opportunities_url ); ?>">
					<?php echo esc_html( $opportunities_label ); ?>
				</a>
			</li>
			<li class="c-breadcrumbs__item" aria-current="page">
				<span><?php echo esc_html( get_the_title( $post_id ) ); ?></span>
			</li>
		</ol>
	</nav>
	<?php
	$custom_breadcrumbs = (string) ob_get_clean();
	?>

	<main id="main-content" class="site-main site-main--career-entry">

		<section class="page-section page-section--career-entry-hero" aria-labelledby="career-entry-heading">
			<?php
			get_template_part(
				'template-parts/patterns/pattern-page-hero',
				null,
				[
					'kicker'      => $type_label,
					'title'       => get_the_title( $post_id ),
					'lead'        => $lead,
					'breadcrumbs' => $custom_breadcrumbs,
					'modifier'    => 'single',
				]
			);
			?>
		</section>

		<section class="page-section page-section--career-entry-content">
			<div class="<?php echo esc_attr( $container ); ?>">
				<div class="career-entry-layout">
					<div class="career-entry-main">
						<?php get_template_part( 'template-parts/career/career-entry', 'content' ); ?>
					</div>

					<aside class="career-entry-aside">
						<?php get_template_part( 'template-parts/career/career-entry', 'aside' ); ?>
					</aside>
				</div>
			</div>
		</section>

		<section class="page-section page-section--career-entry-rodo">
			<div class="<?php echo esc_attr( $container ); ?>">
				<?php get_template_part( 'template-parts/career/career-entry', 'rodo' ); ?>
			</div>
		</section>

	</main>

	<?php
endwhile;

get_footer();
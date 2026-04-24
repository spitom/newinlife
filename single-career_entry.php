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


	ob_start();
	?>
	<nav class="c-breadcrumbs" aria-label="<?php echo esc_attr( inlife_t( 'Okruszki' ) ); ?>">
		<ol class="c-breadcrumbs__list">
			<li class="c-breadcrumbs__item">
				<a class="c-breadcrumbs__link" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<?php echo esc_html( inlife_t( 'Strona główna' ) ); ?>
				</a>
			</li>
			<li class="c-breadcrumbs__item">
				<a class="c-breadcrumbs__link" href="<?php echo esc_url( home_url( '/kariera/' ) ); ?>">
					<?php echo esc_html( inlife_t( 'Kariera' ) ); ?>
				</a>
			</li>
			<li class="c-breadcrumbs__item">
				<a class="c-breadcrumbs__link" href="<?php echo esc_url( home_url( '/kariera/konkursy-i-oferty-pracy/' ) ); ?>">
					<?php echo esc_html( inlife_t( 'Konkursy i oferty pracy' ) ); ?>
				</a>
			</li>
			<li class="c-breadcrumbs__item c-breadcrumbs__item--current" aria-current="page">
				<span class="c-breadcrumbs__current"><?php echo esc_html( get_the_title( $post_id ) ); ?></span>
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
					'breadcrumbs' => $custom_breadcrumbs,
					'modifier'    =>  [ 'single', 'flush' ],
					'title_id'    => 'career-entry-heading',
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
<?php
/**
 * Template Name: Badania – Overview
 *
 * @package UnderStrap
 */

defined('ABSPATH') || exit;

get_header();

$container = inlife_container_class();
?>

<main id="main-content" class="site-main site-main--landing site-main--research-overview">

	<?php get_template_part('template-parts/page/page', 'hero-inner'); ?>

	<section class="page-section page-section--research-intro" aria-labelledby="research-intro-heading">
		<div class="<?php echo esc_attr($container); ?>">
			<div class="research-overview-intro">
				<div class="row">
					<div class="col-xl-10">
						<h2 id="research-intro-heading" class="visually-hidden">
							Wprowadzenie do działu Badania
						</h2>

						<p class="research-overview-intro__lead">
							Poznaj główne obszary działalności naukowej Instytutu: zespoły badawcze,
							laboratoria, projekty, publikacje oraz pozostałe zasoby wspierające rozwój badań.
						</p>

						<!-- <p class="research-overview-intro__text">
							Główna zakładka „Badania” pełni rolę czytelnego punktu wejścia do najważniejszych
							obszarów działalności naukowej Instytutu. Każdy z poniższych modułów prowadzi
							do osobnego widoku z bardziej szczegółową strukturą treści.
						</p> -->
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="page-section page-section--research-nav" aria-labelledby="research-navigation-heading">
		<div class="<?php echo esc_attr($container); ?>">
			<?php get_template_part('template-parts/research/research', 'navigation-grid'); ?>
		</div>
	</section>

</main>

<?php
get_footer();
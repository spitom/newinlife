<?php
/**
 * Posts archive grid
 */

defined( 'ABSPATH' ) || exit;

$container = $args['container'] ?? 'container';
?>

<section class="posts-archive">
	<div class="<?php echo esc_attr( $container ); ?>">

		<?php if ( have_posts() ) : ?>

			<div class="posts-archive__listing c-card-grid">
				<?php while ( have_posts() ) : the_post(); ?>
					<div class="posts-archive__item">
						<?php
						get_template_part(
							'template-parts/posts/posts',
							'card',
							[
								'post_id' => get_the_ID(),
							]
						);
						?>
					</div>
				<?php endwhile; ?>
			</div>

			<?php
			$pagination = paginate_links(
				[
					'type'      => 'list',
					'prev_text' => '←',
					'next_text' => '→',
				]
			);

			if ( $pagination ) :
				?>
				<nav class="posts-archive__pagination" aria-label="<?php echo esc_attr( inlife_t( 'Paginacja' ) ); ?>">
					<?php echo wp_kses_post( $pagination ); ?>
				</nav>
			<?php endif; ?>

		<?php else : ?>

			<div class="posts-empty-state c-surface c-surface--panel">
				<p><?php echo esc_html( inlife_t( 'Brak aktualności do wyświetlenia.' ) ); ?></p>
			</div>

		<?php endif; ?>

	</div>
</section>
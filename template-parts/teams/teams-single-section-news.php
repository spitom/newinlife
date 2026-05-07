<?php
defined( 'ABSPATH' ) || exit;

$team_id = get_the_ID();

$news_query = new WP_Query(
	[
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'posts_per_page' => 6,
		'no_found_rows'  => true,
		'ignore_sticky_posts' => true,
		'meta_query'     => [
			[
				'key'     => 'post_related_teams',
				'value'   => '"' . $team_id . '"',
				'compare' => 'LIKE',
			],
		],
	]
);
?>

<div class="team-section-block team-section-block--news">
	<?php if ( $news_query->have_posts() ) : ?>

		<div class="team-news-list">
			<?php while ( $news_query->have_posts() ) : $news_query->the_post(); ?>
				<?php
				$related_id       = get_the_ID();
				$related_date     = get_the_date( '', $related_id );
				$related_category = function_exists( 'inlife_get_primary_post_category' )
					? inlife_get_primary_post_category( $related_id )
					: null;
				?>

				<article class="team-news-item">
					<div class="team-news-item__meta">
						<?php if ( $related_category ) : ?>
							<span class="team-news-item__category">
								<?php echo esc_html( $related_category->name ); ?>
							</span>
						<?php endif; ?>

						<?php if ( $related_date ) : ?>
							<time class="team-news-item__date" datetime="<?php echo esc_attr( get_the_date( 'c', $related_id ) ); ?>">
								<?php echo esc_html( $related_date ); ?>
							</time>
						<?php endif; ?>
					</div>

					<h3 class="team-news-item__title">
						<a href="<?php the_permalink(); ?>">
							<?php the_title(); ?>
						</a>
					</h3>

					<a class="team-news-item__arrow" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( sprintf( inlife_t( 'Czytaj: %s' ), get_the_title() ) ); ?>">
						→
					</a>
				</article>
			<?php endwhile; ?>
		</div>

		<?php wp_reset_postdata(); ?>

	<?php else : ?>

		<div class="team-section-empty">
			<p><?php echo esc_html( inlife_t( 'Brak aktualności powiązanych z tym zespołem.' ) ); ?></p>
		</div>

	<?php endif; ?>
</div>
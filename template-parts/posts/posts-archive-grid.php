<?php
/**
 * Posts archive grid
 */

defined( 'ABSPATH' ) || exit;

$container = $args['container'] ?? 'container';
?>

<section class="posts-archive">
	<div class="<?php echo esc_attr( $container ); ?>">

		<?php
		$current_cat  = isset( $_GET['news_cat'] ) ? sanitize_key( wp_unslash( $_GET['news_cat'] ) ) : '';
		$current_year = isset( $_GET['news_year'] ) ? absint( $_GET['news_year'] ) : 0;

		$categories = get_categories(
			[
				'hide_empty' => true,
			]
		);

		$exclude_ids = [];

		foreach ( [ 'bez-kategorii', 'uncategorized' ] as $slug ) {
			$term = get_category_by_slug( $slug );

			if ( $term ) {
				$exclude_ids[] = (int) $term->term_id;
			}
		}

		$categories = get_categories(
			[
				'hide_empty' => true,
				'exclude'   => $exclude_ids,
			]
		);

		$years = $GLOBALS['wpdb']->get_col(
			"
			SELECT DISTINCT YEAR(post_date)
			FROM {$GLOBALS['wpdb']->posts}
			WHERE post_type = 'post'
			AND post_status = 'publish'
			ORDER BY post_date DESC
			"
		);
		?>

		<form class="archive-filters posts-filters" method="get" action="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) . '#posts-listing' ); ?>">
			<div class="archive-filters__group" aria-label="<?php echo esc_attr( inlife_t( 'Kategorie aktualności' ) ); ?>">
				<button class="c-pill<?php echo '' === $current_cat ? ' is-active' : ''; ?>" type="submit" name="news_cat" value="">
					<?php echo esc_html( inlife_t( 'Wszystkie' ) ); ?>
				</button>

				<?php foreach ( $categories as $category ) : ?>
					<button
						class="c-pill<?php echo $current_cat === $category->slug ? ' is-active' : ''; ?>"
						type="submit"
						name="news_cat"
						value="<?php echo esc_attr( $category->slug ); ?>"
					>
						<?php echo esc_html( $category->name ); ?>
					</button>
				<?php endforeach; ?>
			</div>

			<label class="archive-filters__select">
				<span class="screen-reader-text"><?php echo esc_html( inlife_t( 'Rok' ) ); ?></span>
				<select name="news_year" onchange="this.form.submit()">
					<option value="0"><?php echo esc_html( inlife_t( 'Wszystkie lata' ) ); ?></option>
					<?php foreach ( $years as $year ) : ?>
						<option value="<?php echo esc_attr( $year ); ?>" <?php selected( $current_year, (int) $year ); ?>>
							<?php echo esc_html( $year ); ?>
						</option>
					<?php endforeach; ?>
				</select>
			</label>

			<?php if ( $current_year ) : ?>
				<input type="hidden" name="news_year" value="<?php echo esc_attr( $current_year ); ?>">
			<?php endif; ?>
		</form>

		<?php if ( have_posts() ) : ?>

			<div class="posts-archive__listing c-card-grid c-card-grid--3 posts-archive__listing--stories">

				<?php while ( have_posts() ) : the_post(); ?>
					<div class="posts-archive__item">
						<?php
						get_template_part(
							'template-parts/posts/posts',
							'card',
							[
								'post_id' => get_the_ID(),
								'variant' => 'story',
							]
						);
						?>
					</div>
				<?php endwhile; ?>

			</div>

			<?php
			the_posts_pagination(
				[
					'mid_size'           => 1,
					'prev_text'          => '←',
					'next_text'          => '→',
					'screen_reader_text' => inlife_t( 'Paginacja' ),
				]
			);
			?>

		<?php else : ?>

			<div class="posts-empty-state c-surface c-surface--panel">
				<p><?php echo esc_html( inlife_t( 'Brak aktualności do wyświetlenia.' ) ); ?></p>
			</div>

		<?php endif; ?>

	</div>
</section>
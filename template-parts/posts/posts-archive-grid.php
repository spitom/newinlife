<?php
/**
 * Posts archive grid
 */

defined( 'ABSPATH' ) || exit;

$container = $args['container'] ?? 'container';

$archive_url = function_exists( 'inlife_get_news_archive_url' )
	? inlife_get_news_archive_url()
	: (string) get_permalink( get_option( 'page_for_posts' ) );
?>

<section class="posts-archive">
	<div class="<?php echo esc_attr( $container ); ?>">

		<?php
		$current_cat  = isset( $_GET['news_cat'] ) ? sanitize_key( wp_unslash( $_GET['news_cat'] ) ) : '';
		$current_year = isset( $_GET['news_year'] ) ? absint( $_GET['news_year'] ) : 0;

		if ( is_category() && ! $current_cat ) {
			$queried_category = get_queried_object();

			if ( $queried_category instanceof WP_Term ) {
				$current_cat = $queried_category->slug;
			}
		}

		$categories = function_exists( 'inlife_get_news_archive_categories' )
			? inlife_get_news_archive_categories()
			: array();

		$years = function_exists( 'inlife_get_news_archive_years' )
			? inlife_get_news_archive_years()
			: array();
		?>

		<div class="archive-filters posts-filters">

			<form class="posts-filters__desktop" method="get" action="<?php echo esc_url( $archive_url . '#posts-listing' ); ?>">
				<?php if ( $current_year ) : ?>
					<input type="hidden" name="news_year" value="<?php echo esc_attr( $current_year ); ?>">
				<?php endif; ?>

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
			</form>

			<form class="posts-filters__year" method="get" action="<?php echo esc_url( $archive_url . '#posts-listing' ); ?>">
				<?php if ( $current_cat ) : ?>
					<input type="hidden" name="news_cat" value="<?php echo esc_attr( $current_cat ); ?>">
				<?php endif; ?>

				<label class="archive-filters__select" for="posts-filter-year-desktop">
					<span class="screen-reader-text">
						<?php echo esc_html( inlife_t( 'Rok' ) ); ?>
					</span>

					<select id="posts-filter-year-desktop" name="news_year">
						<option value="0">
							<?php echo esc_html( inlife_t( 'Wszystkie lata' ) ); ?>
						</option>

						<?php foreach ( $years as $year ) : ?>
							<option value="<?php echo esc_attr( $year ); ?>" <?php selected( $current_year, (int) $year ); ?>>
								<?php echo esc_html( $year ); ?>
							</option>
						<?php endforeach; ?>
					</select>
				</label>

				<button class="posts-filters__submit" type="submit">
					<?php echo esc_html( inlife_t( 'Filtruj' ) ); ?>
				</button>
			</form>

			<form class="posts-filters__mobile" method="get" action="<?php echo esc_url( $archive_url . '#posts-listing' ); ?>">
				<label
					class="archive-filters__select archive-filters__select--category"
					for="posts-filter-category-mobile"
				>
					<span class="screen-reader-text">
						<?php echo esc_html( inlife_t( 'Kategoria' ) ); ?>
					</span>

					<select id="posts-filter-category-mobile" name="news_cat">
						<option value="">
							<?php echo esc_html( inlife_t( 'Wszystkie kategorie' ) ); ?>
						</option>

						<?php foreach ( $categories as $category ) : ?>
							<option
								value="<?php echo esc_attr( $category->slug ); ?>"
								<?php selected( $current_cat, $category->slug ); ?>
							>
								<?php echo esc_html( $category->name ); ?>
							</option>
						<?php endforeach; ?>
					</select>
				</label>

				<label class="archive-filters__select" for="posts-filter-year-mobile">
					<span class="screen-reader-text">
						<?php echo esc_html( inlife_t( 'Rok' ) ); ?>
					</span>

					<select id="posts-filter-year-mobile" name="news_year">
						<option value="0">
							<?php echo esc_html( inlife_t( 'Wszystkie lata' ) ); ?>
						</option>

						<?php foreach ( $years as $year ) : ?>
							<option value="<?php echo esc_attr( $year ); ?>" <?php selected( $current_year, (int) $year ); ?>>
								<?php echo esc_html( $year ); ?>
							</option>
						<?php endforeach; ?>
					</select>
				</label>

				<button class="posts-filters__submit" type="submit">
					<?php echo esc_html( inlife_t( 'Filtruj' ) ); ?>
				</button>
			</form>

		</div>

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
<?php
/**
 * Career archive loop
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;
?>

<?php if ( have_posts() ) : ?>
	<div class="career-archive-list">
		<?php while ( have_posts() ) : the_post(); ?>
			<div class="career-archive-list__item">
				<?php get_template_part( 'template-parts/career/career-archive', 'card' ); ?>
			</div>
		<?php endwhile; ?>
	</div>

	<?php
	$pagination = get_the_posts_pagination(
		[
			'mid_size'           => 1,
			'prev_text'          => esc_html( inlife_t( 'Poprzednia' ) ),
			'next_text'          => esc_html( inlife_t( 'Następna' ) ),
			'screen_reader_text' => esc_html( inlife_t( 'Nawigacja po stronach wyników' ) ),
		]
	);

	if ( $pagination ) :
		?>
		<nav class="career-archive-pagination" aria-label="<?php echo esc_attr( inlife_t( 'Paginacja ogłoszeń' ) ); ?>">
			<?php echo wp_kses_post( $pagination ); ?>
		</nav>
	<?php endif; ?>

<?php else : ?>
	<div class="c-surface c-surface--panel career-archive-empty">
		<p class="career-archive-empty__text mb-0">
			<?php echo esc_html( inlife_t( 'Brak wpisów spełniających kryteria.' ) ); ?>
		</p>
	</div>
<?php endif; ?>
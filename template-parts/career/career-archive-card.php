<?php
/**
 * Career archive card
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

$excerpt = function_exists( 'inlife_get_card_excerpt' )
	? inlife_get_card_excerpt( $post_id, 26 )
	: '';

$type_label = function_exists( 'inlife_get_career_entry_type_label' )
	? inlife_get_career_entry_type_label( $post_id )
	: '';

$unit = function_exists( 'get_field' ) ? get_field( 'career_unit', $post_id ) : '';
$deadline_raw = function_exists( 'get_field' ) ? get_field( 'career_deadline', $post_id ) : '';

$deadline = function_exists( 'inlife_format_career_date' )
	? inlife_format_career_date( $deadline_raw )
	: '';

$type_class = '';

$terms = get_the_terms( $post_id, 'career_entry_type' );

if ( ! empty( $terms ) && ! is_wp_error( $terms ) && function_exists( 'inlife_get_career_type_key_from_slug' ) ) {
	foreach ( $terms as $term ) {
		$resolved_key = inlife_get_career_type_key_from_slug( $term->slug );

		if ( in_array( $resolved_key, [ 'scientific', 'jobs' ], true ) ) {
			$type_class = 'career-archive-card--' . $resolved_key;
			break;
		}
	}
}
?>

<article class="career-archive-card <?php echo esc_attr( $type_class ); ?>">
	<a class="career-archive-card__link c-surface c-surface--record" href="<?php the_permalink(); ?>">

		<?php if ( $type_label ) : ?>
			<p class="career-archive-card__type">
				<?php echo esc_html( $type_label ); ?>
			</p>
		<?php endif; ?>

		<h2 class="career-archive-card__title">
			<?php the_title(); ?>
		</h2>

		<?php if ( $excerpt ) : ?>
			<p class="career-archive-card__excerpt">
				<?php echo esc_html( $excerpt ); ?>
			</p>
		<?php endif; ?>

		<?php if ( $unit || $deadline ) : ?>
			<div class="career-archive-card__meta">
				<?php if ( $unit ) : ?>
					<p class="career-archive-card__meta-item">
						<?php echo esc_html( $unit ); ?>
					</p>
				<?php endif; ?>

				<?php if ( $deadline ) : ?>
					<p class="career-archive-card__meta-item career-archive-card__meta-item--deadline">
						<?php echo esc_html( inlife_t( 'Termin składania' ) ); ?>:
						<?php echo esc_html( $deadline ); ?>
					</p>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<span class="c-readmore career-archive-card__readmore">
			<span class="c-readmore__label">
				<?php echo esc_html( inlife_t( 'Przejdź do wpisu' ) ); ?>
			</span>
			<span class="c-readmore__icon" aria-hidden="true">→</span>
		</span>
	</a>
</article>
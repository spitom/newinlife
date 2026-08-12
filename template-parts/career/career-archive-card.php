<?php
/**
 * Career archive card
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

$args = wp_parse_args(
	$args ?? array(),
	array(
		'heading_level' => 2,
	)
);

$heading_level = (int) $args['heading_level'];

if ( ! in_array( $heading_level, array( 2, 3, 4 ), true ) ) {
	$heading_level = 2;
}

$post_id = get_the_ID();

$type_label = function_exists( 'inlife_get_career_entry_type_label' )
	? inlife_get_career_entry_type_label( $post_id )
	: '';

$unit = function_exists( 'get_field' ) ? get_field( 'career_unit', $post_id ) : '';
$deadline_raw = function_exists( 'get_field' ) ? get_field( 'career_deadline', $post_id ) : '';

$deadline = function_exists( 'inlife_format_career_date' )
	? inlife_format_career_date( $deadline_raw )
	: '';

$primary_type = function_exists( 'inlife_get_career_entry_primary_type' )
	? inlife_get_career_entry_primary_type( (int) $post_id )
	: null;

$type_behavior = array(
	'card_style'    => 'standard',
	'show_deadline' => true,
);

if (
	$primary_type instanceof WP_Term &&
	function_exists( 'inlife_get_career_type_behavior' )
) {
	$type_behavior = array_merge(
		$type_behavior,
		inlife_get_career_type_behavior( $primary_type )
	);
}

$card_style = isset( $type_behavior['card_style'] )
	? (string) $type_behavior['card_style']
	: 'standard';

$type_class = in_array(
	$card_style,
	array( 'scientific', 'jobs' ),
	true
)
	? 'career-archive-card--' . $card_style
	: '';

$show_deadline = ! empty( $type_behavior['show_deadline'] );
?>

<article class="career-archive-card <?php echo esc_attr( $type_class ); ?>">
	<a class="career-archive-card__link c-surface c-surface--record" href="<?php the_permalink(); ?>">

		<?php if ( $type_label ) : ?>
			<p class="career-archive-card__type c-badge c-badge--soft c-badge--compact">
				<?php echo esc_html( $type_label ); ?>
			</p>
		<?php endif; ?>

		<h<?php echo $heading_level; ?> class="career-archive-card__title">
			<?php the_title(); ?>
		</h<?php echo $heading_level; ?>>

		<?php if ( $unit || ( $deadline && $show_deadline ) ) : ?>
			<div class="career-archive-card__meta">
				<?php if ( $unit ) : ?>
					<p class="career-archive-card__meta-item">
						<?php echo esc_html( $unit ); ?>
					</p>
				<?php endif; ?>

				<?php if ( $deadline && $show_deadline ) : ?>
					<p class="career-archive-card__meta-item career-archive-card__meta-item--deadline">
						<span><?php echo esc_html( inlife_t( 'Termin składania ofert' ) ); ?></span>
						<strong><?php echo esc_html( $deadline ); ?></strong>
					</p>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<span class="c-readmore career-archive-card__readmore">
			<span class="c-readmore__label">
				<?php echo esc_html( inlife_t( 'Przejdź do oferty' ) ); ?>
			</span>
			<span class="c-readmore__icon" aria-hidden="true">→</span>
		</span>
	</a>
</article>
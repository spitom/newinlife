<?php
/**
 * Career entry header
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

$type_label = function_exists( 'inlife_get_career_entry_type_label' )
	? inlife_get_career_entry_type_label( $post_id )
	: '';

$position_label = function_exists( 'get_field' ) ? get_field( 'career_position_label', $post_id ) : '';
$deadline_raw   = function_exists( 'get_field' ) ? get_field( 'career_deadline', $post_id ) : '';

$deadline = function_exists( 'inlife_format_career_date' )
	? inlife_format_career_date( $deadline_raw )
	: '';

$type_key = '';
$terms    = get_the_terms( $post_id, 'career_entry_type' );

if ( ! empty( $terms ) && ! is_wp_error( $terms ) && function_exists( 'inlife_get_career_type_key_from_slug' ) ) {
	foreach ( $terms as $term ) {
		$resolved_key = inlife_get_career_type_key_from_slug( $term->slug );

		if ( $resolved_key ) {
			$type_key = $resolved_key;
			break;
		}
	}
}

$back_url = function_exists( 'inlife_get_career_term_archive_url' ) && $type_key
	? inlife_get_career_term_archive_url( $type_key )
	: home_url( '/' );

ob_start();
?>
<a href="<?php echo esc_url( $back_url ); ?>" class="c-readmore career-entry-header__back-link">
	<span class="c-readmore__label"><?php echo esc_html( inlife_t( 'Wróć do ogłoszeń' ) ); ?></span>
	<span class="c-readmore__icon" aria-hidden="true">←</span>
</a>
<?php
$action_html = (string) ob_get_clean();

$lead = has_excerpt() ? get_the_excerpt( $post_id ) : '';

get_template_part(
	'template-parts/components/section-header',
	null,
	[
		'kicker'      => $type_label,
		'title'       => get_the_title( $post_id ),
		'lead'        => $lead,
		'action_html' => $action_html,
		'title_id'    => 'career-entry-heading',
		'class'       => 'career-entry-header__section-header',
	]
);
?>

<?php if ( $position_label || $deadline ) : ?>
	<div class="career-entry-header__meta c-surface c-surface--compact">
		<?php if ( $position_label ) : ?>
			<p class="career-entry-header__meta-item">
				<?php echo esc_html( $position_label ); ?>
			</p>
		<?php endif; ?>

		<?php if ( $deadline ) : ?>
			<p class="career-entry-header__meta-item career-entry-header__meta-item--deadline">
				<?php echo esc_html( inlife_t( 'Termin składania' ) ); ?>:
				<?php echo esc_html( $deadline ); ?>
			</p>
		<?php endif; ?>
	</div>
<?php endif; ?>
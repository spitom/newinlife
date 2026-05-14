<?php
/**
 * Career entry aside
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

$type_label = function_exists( 'inlife_get_career_entry_type_label' )
	? inlife_get_career_entry_type_label( $post_id )
	: '';

$published_date = get_the_date( '', $post_id );

$deadline_raw = function_exists( 'get_field' ) ? get_field( 'career_deadline', $post_id ) : '';

$deadline = function_exists( 'inlife_format_career_date' )
	? inlife_format_career_date( $deadline_raw )
	: '';
?>

<div class="career-entry-aside__stack">

	<section class="career-entry-aside__panel c-surface c-surface--panel" aria-labelledby="career-entry-info-heading">
		<h2 id="career-entry-info-heading" class="career-entry-aside__heading">
			<?php echo esc_html( inlife_t( 'Informacje' ) ); ?>
		</h2>

		<ul class="career-entry-aside__list">
			<?php if ( $type_label ) : ?>
				<li>
					<span class="career-entry-aside__label"><?php echo esc_html( inlife_t( 'Typ ogłoszenia' ) ); ?></span>
					<span class="career-entry-aside__value"><?php echo esc_html( $type_label ); ?></span>
				</li>
			<?php endif; ?>

			<?php if ( $published_date ) : ?>
				<li>
					<span class="career-entry-aside__label"><?php echo esc_html( inlife_t( 'Data publikacji' ) ); ?></span>
					<span class="career-entry-aside__value"><?php echo esc_html( $published_date ); ?></span>
				</li>
			<?php endif; ?>

			<?php if ( $deadline ) : ?>
				<li>
					<span class="career-entry-aside__label">
						<?php echo esc_html( inlife_t( 'Termin składania ofert' ) ); ?>
					</span>
					<span class="career-entry-aside__value career-entry-aside__value--deadline">
						<?php echo esc_html( $deadline ); ?>
					</span>
				</li>
			<?php endif; ?>
		</ul>
	</section>

</div>
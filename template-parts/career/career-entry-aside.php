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
		</ul>
	</section>

	<section class="career-entry-aside__panel c-surface c-surface--panel" aria-labelledby="career-entry-note-heading">
		<h2 id="career-entry-note-heading" class="career-entry-aside__heading">
			<?php echo esc_html( inlife_t( 'Szczegóły' ) ); ?>
		</h2>

		<p class="career-entry-aside__note">
			<?php echo esc_html( inlife_t( 'Szczegółowe informacje, wymagania oraz sposób składania dokumentów znajdują się w treści ogłoszenia.' ) ); ?>
		</p>
	</section>

</div>
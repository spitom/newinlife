<?php
/**
 * Career trainings section
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

$section_kicker = function_exists( 'get_field' ) ? get_field( 'career_trainings_kicker', $post_id ) : '';
$section_title  = function_exists( 'get_field' ) ? get_field( 'career_trainings_title', $post_id ) : '';
$section_text   = function_exists( 'get_field' ) ? get_field( 'career_trainings_text', $post_id ) : '';

$section_kicker = $section_kicker ?: inlife_t( 'Szkolenia' );
$section_title  = $section_title ?: inlife_t( 'Szkolenia i kalendarz zapisów' );
$section_text   = $section_text ?: inlife_t( 'W tej sekcji będzie można zapisać się na szkolenia oraz sprawdzić aktualny kalendarz szkoleń organizowanych przez Instytut.' );

if ( ! $section_kicker && ! $section_title && ! $section_text ) {
	return;
}
?>

<div class="career-trainings">
	<div class="career-trainings__layout">
		<?php
		get_template_part(
			'template-parts/components/section-header',
			null,
			[
				'kicker'   => $section_kicker,
				'title'    => $section_title,
				'lead'     => $section_text,
				'title_id' => 'career-trainings-heading',
			]
		);
		?>
	</div>
</div>
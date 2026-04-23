<?php
defined( 'ABSPATH' ) || exit;

$laboratory_id = get_the_ID();

$laboratory_profile     = function_exists( 'get_field' ) ? get_field( 'laboratory_profile', $laboratory_id ) : '';
$laboratory_cooperation = function_exists( 'get_field' ) ? get_field( 'laboratory_cooperation', $laboratory_id ) : '';

$profile_content = $laboratory_profile ? $laboratory_profile : get_the_content();

$profile_plain = trim(
	wp_strip_all_tags(
		html_entity_decode(
			(string) $profile_content,
			ENT_QUOTES,
			get_bloginfo( 'charset' )
		)
	)
);

$show_profile_toggle = mb_strlen( $profile_plain ) > 650;
?>

<section class="lab-profile" aria-labelledby="lab-profile-title">
	<div class="lab-profile__main c-surface c-surface--panel">
		<header class="section-heading">
			<h2 id="lab-profile-title" class="section-title">
				<?php echo esc_html( inlife_t( 'Profil jednostki' ) ); ?>
			</h2>
		</header>

		<div
			class="lab-profile__content entry-content<?php echo $show_profile_toggle ? ' is-collapsed' : ''; ?>"
			data-lab-profile-description
			id="labProfileContent"
		>
			<?php echo wp_kses_post( $profile_content ); ?>
		</div>

		<?php if ( $show_profile_toggle ) : ?>
			<div class="lab-profile__actions">
				<button
					type="button"
					class="lab-profile__toggle"
					data-lab-profile-toggle
					aria-expanded="false"
					aria-controls="labProfileContent"
				>
					<span class="lab-profile__toggle-text lab-profile__toggle-text--more">
						<?php echo esc_html( inlife_t( 'Pokaż więcej' ) ); ?>
					</span>
					<span class="lab-profile__toggle-text lab-profile__toggle-text--less">
						<?php echo esc_html( inlife_t( 'Pokaż mniej' ) ); ?>
					</span>
					<span class="lab-profile__toggle-arrow" aria-hidden="true">↓</span>
				</button>
			</div>
		<?php endif; ?>

		<div class="lab-profile__cooperation">
			<div class="lab-info-card lab-info-card--cooperation">
				<h3 class="lab-info-card__title">
					<?php echo esc_html( inlife_t( 'Współpraca i usługi' ) ); ?>
				</h3>

				<div class="lab-info-card__text entry-content">
					<?php
					if ( $laboratory_cooperation ) {
						echo wp_kses_post( $laboratory_cooperation );
					} else {
						echo '<p>' . esc_html( inlife_t( 'Dane dotyczące współpracy i zastosowań zostaną rozwinięte wraz z modułem biznesowym.' ) ) . '</p>';
					}
					?>
				</div>
			</div>
		</div>
	</div>
</section>
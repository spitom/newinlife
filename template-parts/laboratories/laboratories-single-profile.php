<?php
defined( 'ABSPATH' ) || exit;

$laboratory_profile     = function_exists( 'get_field' ) ? get_field( 'laboratory_profile' ) : '';
$laboratory_scope       = function_exists( 'get_field' ) ? get_field( 'laboratory_scope' ) : '';
$laboratory_cooperation = function_exists( 'get_field' ) ? get_field( 'laboratory_cooperation' ) : '';
?>

<div class="lab-profile">
	<div class="row g-4 g-xl-5">

		<div class="col-lg-8">
			<div class="lab-profile__main">
				<header class="section-heading">
					<h2 class="section-title"><?php echo esc_html( inlife_t( 'Profil jednostki' ) ); ?></h2>
				</header>

				<div class="lab-profile__content entry-content">
					<?php
					if ( $laboratory_profile ) {
						echo wp_kses_post( $laboratory_profile );
					} else {
						the_content();
					}
					?>
				</div>
			</div>
		</div>

		<div class="col-lg-4">
			<aside class="lab-profile__aside">
				<div class="lab-info-card">
					<h3 class="lab-info-card__title"><?php echo esc_html( inlife_t( 'Zakres działalności' ) ); ?></h3>
					<p class="lab-info-card__text">
						<?php
						echo esc_html(
							$laboratory_scope
								? $laboratory_scope
								: inlife_t( 'Informacje zostaną uzupełnione na kolejnym etapie wdrożenia.' )
						);
						?>
					</p>
				</div>

				<div class="lab-info-card">
					<h3 class="lab-info-card__title"><?php echo esc_html( inlife_t( 'Współpraca' ) ); ?></h3>
					<p class="lab-info-card__text">
						<?php
						echo esc_html(
							$laboratory_cooperation
								? $laboratory_cooperation
								: inlife_t( 'Dane dotyczące współpracy i zastosowań zostaną rozwinięte wraz z modułem biznesowym.' )
						);
						?>
					</p>
				</div>
			</aside>
		</div>

	</div>
</div>
<?php
/**
 * Institutional seminar system content.
 *
 * @package newinlife
 */

defined( 'ABSPATH' ) || exit;

$container = function_exists( 'inlife_container_class' )
	? inlife_container_class()
	: 'container';

$intro = function_exists( 'get_field' )
	? (string) get_field( 'seminar_system_intro' )
	: '';

$rows = function_exists( 'get_field' )
	? get_field( 'seminar_system_rows' )
	: [];
?>

<section
	class="page-section page-section--seminar-system-content"
	aria-labelledby="seminar-system-heading"
>
	<div class="<?php echo esc_attr( $container ); ?>">

		<div class="seminar-system">

			<div class="seminar-system__header">
                <h2
                    id="seminar-system-heading"
                    class="visually-hidden"
                >
                    <?php echo esc_html( inlife_t( 'Informacje o systemie seminariów instytutowych' ) ); ?>
                </h2>

                <?php if ( $intro ) : ?>
                    <div class="seminar-system__intro">
                        <?php echo wp_kses_post( $intro ); ?>
                    </div>
                <?php endif; ?>
            </div>

			<?php if ( is_array( $rows ) && $rows ) : ?>

				<div
					class="seminar-system-table-wrap"
					role="region"
					aria-labelledby="seminar-system-table-caption"
					tabindex="0"
				>
					<table class="seminar-system-table">

						<caption
							id="seminar-system-table-caption"
							class="visually-hidden"
						>
							<?php echo esc_html( inlife_t( 'Rodzaje seminariów instytutowych' ) ); ?>
						</caption>

						<thead>
							<tr>
								<th scope="col">
									<?php echo esc_html( inlife_t( 'Typ seminarium' ) ); ?>
								</th>

								<th scope="col">
									<?php echo esc_html( inlife_t( 'Częstotliwość' ) ); ?>
								</th>

								<th scope="col">
									<?php echo esc_html( inlife_t( 'Forma spotkania' ) ); ?>
								</th>

								<th scope="col">
									<?php echo esc_html( inlife_t( 'Prelegent' ) ); ?>
								</th>

								<th scope="col">
									<?php echo esc_html( inlife_t( 'Organizator' ) ); ?>
								</th>
							</tr>
						</thead>

						<tbody>

							<?php foreach ( $rows as $row ) : ?>
								<?php
								$seminar_type = trim(
									(string) ( $row['seminar_type'] ?? '' )
								);

								$frequency = trim(
									(string) ( $row['seminar_frequency'] ?? '' )
								);

								$format = trim(
									(string) ( $row['seminar_format'] ?? '' )
								);

								$speaker = trim(
									(string) ( $row['seminar_speaker'] ?? '' )
								);

								$organizer = trim(
									(string) ( $row['seminar_organizer'] ?? '' )
								);
								?>

								<tr>
									<th scope="row">
										<?php echo esc_html( $seminar_type ); ?>
									</th>

									<td>
										<?php echo nl2br( esc_html( $frequency ) ); ?>
									</td>

									<td>
										<?php echo esc_html( $format ); ?>
									</td>

									<td>
										<?php echo nl2br( esc_html( $speaker ) ); ?>
									</td>

									<td>
										<?php echo nl2br( esc_html( $organizer ) ); ?>
									</td>
								</tr>

							<?php endforeach; ?>

						</tbody>

					</table>
				</div>

			<?php endif; ?>

		</div>

	</div>
</section>
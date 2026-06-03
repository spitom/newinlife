<?php
defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

$intro_kicker = inlife_get_acf_field( 'structure_intro_kicker', $post_id, inlife_t( 'Struktura organizacyjna' ) );
$intro_title  = inlife_get_acf_field( 'structure_intro_title', $post_id, inlife_t( 'Jak zorganizowany jest Instytut' ) );
$intro_text   = inlife_get_acf_field(
	'structure_intro_text',
	$post_id,
	inlife_t( 'Struktura Instytutu łączy działalność naukową, zarządczą, administracyjną oraz wsparcie badań. Dzięki temu zespoły badawcze, laboratoria i jednostki organizacyjne mogą skutecznie realizować projekty naukowe, wdrożeniowe i edukacyjne.' )
);

$intro_image = inlife_get_acf_field( 'structure_intro_image', $post_id, 0 );
$image_id    = 0;

if ( is_array( $intro_image ) && ! empty( $intro_image['ID'] ) ) {
	$image_id = (int) $intro_image['ID'];
} elseif ( is_numeric( $intro_image ) ) {
	$image_id = (int) $intro_image;
}
?>

<div class="about-structure-landing">

	<div class="about-structure-landing__intro">
		<div class="about-structure-landing__intro-content">
			<div class="section-heading section-heading--left">
				<?php if ( $intro_kicker ) : ?>
					<p class="section-kicker"><?php echo esc_html( $intro_kicker ); ?></p>
				<?php endif; ?>

				<h2 id="about-structure-landing-heading" class="section-title">
					<?php echo esc_html( $intro_title ); ?>
				</h2>
			</div>

			<?php if ( $intro_text ) : ?>
				<div class="c-editorial-content about-structure-landing__intro-text">
					<?php echo wp_kses_post( wpautop( $intro_text ) ); ?>
				</div>
			<?php endif; ?>
		</div>

		<?php if ( $image_id ) : ?>

			<div class="about-structure-landing__media">
				<button
					type="button"
					class="about-structure-landing__image-button"
					data-structure-lightbox-open
					aria-label="<?php echo esc_attr( inlife_t( 'Powiększ schemat organizacyjny' ) ); ?>"
				>
					<?php
					echo wp_get_attachment_image(
						$image_id,
						'large',
						false,
						[
							'class'   => 'about-structure-landing__image',
							'loading' => 'lazy',
							'alt'     => '',
						]
					);
					?>

					<span class="about-structure-landing__zoom" aria-hidden="true">
						<i class="bi bi-search"></i>
						<span><?php echo esc_html( inlife_t( 'Powiększ schemat' ) ); ?></span>
					</span>
				</button>
			</div>

			<dialog
				class="about-structure-lightbox"
				data-structure-lightbox
				aria-label="<?php echo esc_attr( inlife_t( 'Schemat organizacyjny' ) ); ?>"
			>
				<button
					type="button"
					class="about-structure-lightbox__close"
					data-structure-lightbox-close
					aria-label="<?php echo esc_attr( inlife_t( 'Zamknij powiększenie' ) ); ?>"
				>
					<span aria-hidden="true">×</span>
				</button>

				<?php
				echo wp_get_attachment_image(
					$image_id,
					'full',
					false,
					[
						'class' => 'about-structure-lightbox__image',
						'alt'   => '',
					]
				);
				?>
			</dialog>
		<?php endif; ?>
	</div>

	<?php if ( function_exists( 'have_rows' ) && have_rows( 'structure_sections', $post_id ) ) : ?>
		<div class="about-structure-landing__sections">
			<?php
			while ( have_rows( 'structure_sections', $post_id ) ) :
				the_row();

				$section_kicker = get_sub_field( 'section_kicker' );
				$section_title  = get_sub_field( 'section_title' );
				$section_text   = get_sub_field( 'section_text' );
				?>

				<section class="about-structure-landing__section" aria-labelledby="<?php echo esc_attr( sanitize_title( $section_title ) ); ?>">
					<div class="about-structure-landing__section-header">
						<?php if ( $section_kicker ) : ?>
							<p class="section-kicker"><?php echo esc_html( $section_kicker ); ?></p>
						<?php endif; ?>

						<?php if ( $section_title ) : ?>
							<h2 id="<?php echo esc_attr( sanitize_title( $section_title ) ); ?>" class="section-title">
								<?php echo esc_html( $section_title ); ?>
							</h2>
						<?php endif; ?>

						<?php if ( $section_text ) : ?>
							<div class="c-editorial-content about-structure-landing__section-text">
								<?php echo wp_kses_post( wpautop( $section_text ) ); ?>
							</div>
						<?php endif; ?>
					</div>

					<?php if ( have_rows( 'section_items' ) ) : ?>
						<div class="c-card-grid c-card-grid--3 about-structure-landing__items">
							<?php
							while ( have_rows( 'section_items' ) ) :
								the_row();

								$item_title    = get_sub_field( 'item_title' );
								$item_name     = get_sub_field( 'item_name' );
								$item_position = get_sub_field( 'item_position' );
								$item_email    = get_sub_field( 'item_email' );
								$item_email_2  = get_sub_field( 'item_email_2' );
								$item_phone    = get_sub_field( 'item_phone' );
								$item_phone_2  = get_sub_field( 'item_phone_2' );
								$item_link     = get_sub_field( 'item_link' );

								$item_url   = is_array( $item_link ) && ! empty( $item_link['url'] ) ? $item_link['url'] : '';
								$item_label = is_array( $item_link ) && ! empty( $item_link['title'] ) ? $item_link['title'] : inlife_t( 'Zobacz więcej' );
								?>

								<article class="about-structure-person">
									<?php if ( $item_title ) : ?>
										<h3 class="about-structure-person__title">
											<?php echo esc_html( $item_title ); ?>
										</h3>
									<?php endif; ?>

									<?php if ( $item_name ) : ?>
										<p class="about-structure-person__name">
											<?php echo esc_html( $item_name ); ?>
										</p>
									<?php endif; ?>

									<?php if ( $item_position ) : ?>
										<p class="about-structure-person__position">
											<?php echo esc_html( $item_position ); ?>
										</p>
									<?php endif; ?>

									<?php
									$emails = array_filter( [ $item_email, $item_email_2 ] );
									$phones = array_filter( [ $item_phone, $item_phone_2 ] );
									?>

									<?php if ( $emails || $phones ) : ?>
										<div class="about-structure-person__contacts">
											<?php foreach ( $emails as $email ) : ?>
												<p class="about-structure-person__contact">
													<span class="about-structure-person__icon" aria-hidden="true">
														<i class="bi bi-envelope"></i>
													</span>

													<?php
													if ( function_exists( 'inlife_render_obfuscated_email_link' ) ) {
														echo inlife_render_obfuscated_email_link(
															$email,
															'about-structure-person__email'
														); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
													} else {
														echo '<a class="about-structure-person__email" href="' . esc_url( 'mailto:' . antispambot( $email ) ) . '">' . esc_html( antispambot( $email ) ) . '</a>';
													}
													?>
												</p>
											<?php endforeach; ?>

											<?php foreach ( $phones as $phone ) : ?>
												<p class="about-structure-person__contact">
													<span class="about-structure-person__icon" aria-hidden="true">
														<i class="bi bi-telephone"></i>
													</span>

													<a href="<?php echo esc_url( 'tel:' . preg_replace( '/[^0-9+]/', '', $phone ) ); ?>">
														<?php echo esc_html( $phone ); ?>
													</a>
												</p>
											<?php endforeach; ?>
										</div>
									<?php endif; ?>

									<?php if ( $item_url ) : ?>
										<a class="c-readmore about-structure-person__link" href="<?php echo esc_url( $item_url ); ?>">
											<?php echo esc_html( $item_label ); ?>
											<span class="c-readmore__icon" aria-hidden="true">→</span>
										</a>
									<?php endif; ?>
								</article>

							<?php endwhile; ?>
						</div>
					<?php endif; ?>
				</section>

			<?php endwhile; ?>
		</div>
	<?php endif; ?>

</div>
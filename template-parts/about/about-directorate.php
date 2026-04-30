<?php
defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

$people = [];

if ( function_exists( 'have_rows' ) && have_rows( 'about_directorate', $post_id ) ) {
	while ( have_rows( 'about_directorate', $post_id ) ) {
		the_row();

		$name   = get_sub_field( 'name' );
		$role   = get_sub_field( 'role' );
		$email  = get_sub_field( 'email' );
		$image  = get_sub_field( 'image' );
		$person = get_sub_field( 'person' );

		$image_id = 0;

		if ( is_array( $image ) && ! empty( $image['ID'] ) ) {
			$image_id = (int) $image['ID'];
		} elseif ( is_numeric( $image ) ) {
			$image_id = (int) $image;
		}

		$url = '';

		if ( $person instanceof WP_Post ) {
			$url = get_permalink( $person->ID );
		}

		if ( $name || $role || $email || $image_id ) {
			$people[] = [
				'name'     => $name,
				'role'     => $role,
				'email'    => $email,
				'image_id' => $image_id,
				'url'      => $url,
			];
		}
	}
}

if ( empty( $people ) ) {
	return;
}
?>

<div class="about-directorate">

	<header class="about-directorate__header">
		<p class="about-directorate__kicker">
			<?php echo esc_html( inlife_t( 'Zarządzanie' ) ); ?>
		</p>

		<h2 id="about-directorate-heading" class="about-directorate__title">
			<?php echo esc_html( inlife_t( 'Dyrekcja Instytutu' ) ); ?>
		</h2>
	</header>

	<div class="about-directorate__list">
		<?php foreach ( $people as $person_item ) : ?>
			<article class="about-leader">

				<div class="about-leader__media">
					<?php if ( $person_item['image_id'] ) : ?>
						<?php
						echo wp_get_attachment_image(
							$person_item['image_id'],
							'medium_large',
							false,
							[
								'class'   => 'about-leader__image',
								'loading' => 'lazy',
								'alt'     => '',
							]
						);
						?>
					<?php else : ?>
						<div class="about-leader__placeholder" aria-hidden="true"></div>
					<?php endif; ?>
				</div>

				<div class="about-leader__content">
					<?php if ( $person_item['role'] ) : ?>
						<p class="about-leader__role">
							<?php echo esc_html( $person_item['role'] ); ?>
						</p>
					<?php endif; ?>

					<?php if ( $person_item['name'] ) : ?>
						<h3 class="about-leader__name">
							<?php echo esc_html( $person_item['name'] ); ?>
						</h3>
					<?php endif; ?>

					<?php if ( $person_item['email'] ) : ?>
						<p class="about-leader__email">
							<a href="mailto:<?php echo esc_attr( $person_item['email'] ); ?>">
								<?php echo esc_html( function_exists( 'inlife_mask_email' ) ? inlife_mask_email( $person_item['email'] ) : str_replace( '@', ' [at] ', $person_item['email'] ) ); ?>
							</a>
						</p>
					<?php endif; ?>

					<?php if ( $person_item['url'] ) : ?>
						<a class="c-readmore about-leader__readmore" href="<?php echo esc_url( $person_item['url'] ); ?>">
							<?php echo esc_html( inlife_t( 'Zobacz profil' ) ); ?>
							<span class="c-readmore__icon" aria-hidden="true">→</span>
						</a>
					<?php endif; ?>
				</div>

			</article>
		<?php endforeach; ?>
	</div>

</div>
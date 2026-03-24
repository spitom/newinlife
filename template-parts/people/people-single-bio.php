<?php
defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

$short_bio = get_field( 'person_short_bio', $post_id );
$long_bio  = get_field( 'person_long_bio', $post_id );

$interests = get_field( 'person_research_interests', $post_id );
$special   = get_field( 'person_specializations', $post_id );

$is_scientific = has_term( 'scientific', 'people_type', $post_id );
?>

<div class="people-single-bio">

	<?php if ( $short_bio ) : ?>
		<p class="people-single-bio__lead">
			<?php echo esc_html( $short_bio ); ?>
		</p>
	<?php endif; ?>

	<div class="people-single-bio__content">
		<?php
		if ( $long_bio ) {
			echo wp_kses_post( wpautop( $long_bio ) );
		} else {
			the_content();
		}
		?>
	</div>

	<?php if ( $is_scientific && ( $interests || $special ) ) : ?>
		<div class="people-single-bio__extra">

			<?php if ( $interests ) : ?>
				<h2><?php esc_html_e( 'Zainteresowania badawcze', 'newinlife' ); ?></h2>
				<p><?php echo esc_html( $interests ); ?></p>
			<?php endif; ?>

			<?php if ( $special ) : ?>
				<h2><?php esc_html_e( 'Specjalizacje', 'newinlife' ); ?></h2>
				<p><?php echo esc_html( $special ); ?></p>
			<?php endif; ?>

		</div>
	<?php endif; ?>

</div>
<?php
/**
 * Template Name: Kontakt
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

get_header();

$container = function_exists( 'inlife_container_class' ) ? inlife_container_class() : 'container';
$post_id   = get_the_ID();

$hero_kicker = inlife_get_acf_field( 'contact_hero_kicker', $post_id, inlife_t( 'Kontakt' ) );
$hero_title  = inlife_get_acf_field( 'contact_hero_title', $post_id, get_the_title() );
$hero_lead   = inlife_get_acf_field(
	'contact_hero_lead',
	$post_id,
	inlife_t( 'Dane kontaktowe, lokalizacja oraz informacje formalne Instytutu.' )
);

$formal_field_names = [
	'contact_nip',
	'contact_regon',
	'contact_rin',
	'contact_pic',
	'contact_epuap',
	'contact_edoreczenia',
];

$has_formal_items = false;

foreach ( $formal_field_names as $formal_field_name ) {
	$formal_value = inlife_get_acf_field(
		$formal_field_name,
		$post_id
	);

	if ( '' !== trim( (string) $formal_value ) ) {
		$has_formal_items = true;
		break;
	}
}

$related_items = inlife_get_acf_field(
	'contact_related_items',
	$post_id,
	[]
);

$has_related_items = is_array( $related_items ) && ! empty( $related_items );
?>

<main id="main-content" class="site-main site-main--contact">

	<section class="page-section page-section--contact-hero">
		<?php
		get_template_part(
			'template-parts/patterns/pattern-page-hero',
			null,
			[
				'kicker'      => $hero_kicker,
				'title'       => $hero_title,
				'lead'        => $hero_lead,
				'breadcrumbs' => true,
				'title_id'    => 'contact-hero-heading',
			]
		);
		?>
	</section>

	<section class="page-section page-section--contact-main" aria-labelledby="contact-main-heading">
		<div class="<?php echo esc_attr( $container ); ?>">
			<?php get_template_part( 'template-parts/contact/contact', 'main' ); ?>
		</div>
	</section>

	<?php if ( $has_formal_items ) : ?>
		<section
			class="page-section page-section--contact-formal"
			aria-labelledby="contact-formal-heading"
		>
			<div class="<?php echo esc_attr( $container ); ?>">
				<?php get_template_part( 'template-parts/contact/contact', 'formal' ); ?>
			</div>
		</section>
	<?php endif; ?>

	<?php if ( $has_related_items ) : ?>
		<section
			class="page-section page-section--contact-key-contacts"
			aria-labelledby="contact-key-contacts-heading"
		>
			<div class="<?php echo esc_attr( $container ); ?>">
				<?php get_template_part( 'template-parts/contact/contact', 'key-contacts' ); ?>
			</div>
		</section>
	<?php endif; ?>

</main>

<?php
get_footer();
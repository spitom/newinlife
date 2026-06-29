<?php
/**
 * Career opportunities – secondary entry points.
 *
 * Dynamic cards for Career types configured as
 * "Wyniki i archiwum".
 *
 * @package UnderStrap
 */

defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

$section_kicker = function_exists( 'get_field' )
	? get_field( 'career_opportunities_secondary_kicker', $post_id )
	: '';

$section_title = function_exists( 'get_field' )
	? get_field( 'career_opportunities_secondary_title', $post_id )
	: '';

$section_text = function_exists( 'get_field' )
	? get_field( 'career_opportunities_secondary_text', $post_id )
	: '';

$section_kicker = $section_kicker ?: inlife_t( 'Informacje' );
$section_title  = $section_title ?: inlife_t( 'Wyniki i archiwum ogłoszeń' );
$section_text   = $section_text ?: inlife_t( 'Sprawdź wyniki zakończonych naborów oraz archiwalne ogłoszenia o pracę i konkursy na stanowiska naukowe.' );

$secondary_types = function_exists( 'inlife_get_career_secondary_types' )
	? inlife_get_career_secondary_types()
	: array();

get_template_part(
	'template-parts/components/section-header',
	null,
	array(
		'kicker'   => $section_kicker,
		'title'    => $section_title,
		'lead'     => $section_text,
		'title_id' => 'career-secondary-heading',
	)
);
?>

<?php if ( ! empty( $secondary_types ) ) : ?>
	<div class="c-card-grid c-card-grid--2 career-opportunities-secondary-grid">
		<?php foreach ( $secondary_types as $secondary_type ) : ?>
			<?php
			$term = $secondary_type['term'] ?? null;

			if ( ! $term instanceof WP_Term ) {
				continue;
			}

			$url = get_term_link( $term );

			if ( is_wp_error( $url ) ) {
				continue;
			}

			$description = function_exists(
				'inlife_get_career_type_secondary_description'
			)
				? inlife_get_career_type_secondary_description( $term )
				: '';
			?>

			<a
				class="c-surface c-surface--panel career-opportunities-entry-card"
				href="<?php echo esc_url( $url ); ?>"
			>
				<h3 class="career-opportunities-entry-card__title">
					<?php echo esc_html( $term->name ); ?>
				</h3>

				<?php if ( '' !== $description ) : ?>
					<div class="career-opportunities-entry-card__text">
						<?php echo wp_kses_post( wpautop( $description ) ); ?>
					</div>
				<?php endif; ?>

				<span class="c-readmore career-opportunities-entry-card__readmore">
					<span class="c-readmore__label">
						<?php echo esc_html( inlife_t( 'Zobacz komunikaty' ) ); ?>
					</span>
					<span class="c-readmore__icon" aria-hidden="true">→</span>
				</span>
			</a>
		<?php endforeach; ?>
	</div>
<?php endif; ?>
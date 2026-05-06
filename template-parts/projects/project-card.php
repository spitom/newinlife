<?php
/**
 * Project card.
 *
 * @package newinlife-child
 */

defined( 'ABSPATH' ) || exit;

$post_id      = get_the_ID();
$project_url  = function_exists( 'inlife_get_project_url' ) ? inlife_get_project_url( $post_id ) : get_permalink( $post_id );
$project_lead = function_exists( 'get_field' ) ? get_field( 'project_lead', $post_id ) : '';
$project_logo = function_exists( 'get_field' ) ? get_field( 'project_logo', $post_id ) : '';
$is_external  = function_exists( 'inlife_is_project_external' ) ? inlife_is_project_external( $post_id ) : false;

$link_attrs = $is_external ? ' target="_blank" rel="noopener noreferrer"' : '';

$logo_url = '';
$logo_alt = '';

if ( ! empty( $project_logo ) && is_array( $project_logo ) ) {
	$logo_url = $project_logo['sizes']['medium_large'] ?? $project_logo['sizes']['medium'] ?? $project_logo['url'] ?? '';
	$logo_alt = $project_logo['alt'] ?? '';
}

if ( '' === $logo_alt ) {
	$logo_alt = get_the_title( $post_id );
}
?>

<article <?php post_class( 'project-card c-card c-card--project c-card--with-media', $post_id ); ?>>
	<div class="project-card__frame c-card__frame">
		<div class="project-card__inner c-card__inner">

			<div class="project-card__media c-card__media">
				<a
					class="project-card__media-link c-card__media-link"
					href="<?php echo esc_url( $project_url ); ?>"
					<?php echo $link_attrs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					aria-hidden="true"
					tabindex="-1"
				>
					<?php if ( $logo_url ) : ?>
						<img
							class="project-card__image c-card__image"
							src="<?php echo esc_url( $logo_url ); ?>"
							alt="<?php echo esc_attr( $logo_alt ); ?>"
							loading="lazy"
						>
					<?php else : ?>
						<div class="project-card__placeholder c-card__placeholder">
							<span><?php echo esc_html( inlife_t( 'Logo projektu' ) ); ?></span>
						</div>
					<?php endif; ?>
				</a>
			</div>

			<div class="project-card__body c-card__body">
				<h3 class="project-card__title c-card__title">
					<a
						class="project-card__title-link c-card__title-link"
						href="<?php echo esc_url( $project_url ); ?>"
						<?php echo $link_attrs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					>
						<?php the_title(); ?>
					</a>
				</h3>

				<?php if ( ! empty( $project_lead ) ) : ?>
					<p class="project-card__lead">
						<?php echo esc_html( $project_lead ); ?>
					</p>
				<?php endif; ?>

				<a
					class="project-card__link c-readmore"
					href="<?php echo esc_url( $project_url ); ?>"
					<?php echo $link_attrs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				>
					<?php echo esc_html( inlife_t( 'Przejdź do projektu' ) ); ?>
					<span class="c-readmore__icon" aria-hidden="true">→</span>
				</a>
			</div>

		</div>
	</div>
</article>
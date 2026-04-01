<?php
/**
 * Team publications year filter.
 *
 * @package newinlife-child
 */

defined( 'ABSPATH' ) || exit;

$years        = $args['years'] ?? array();
$current_year = $args['current_year'] ?? '';
$base_url     = $args['base_url'] ?? '';

if ( empty( $years ) || ! is_array( $years ) ) {
	return;
}

if ( empty( $base_url ) ) {
	$base_url = get_permalink();
}
?>

<nav
	class="team-publications-filter"
	aria-label="<?php echo esc_attr( function_exists( 'inlife_t' ) ? inlife_t( 'Filtr publikacji po latach' ) : __( 'Filtr publikacji po latach', 'newinlife-child' ) ); ?>"
>
	<ul class="team-publications-filter__list list-unstyled mb-0">
		<?php foreach ( $years as $year ) : ?>
			<?php
			$is_active = (string) $year === (string) $current_year;

			$link = add_query_arg(
                array(
                    'team_section' => 'publikacje',
                    'pub_year'     => $year,
                ),
                $base_url
            ) . '#team-publications-section';
			?>
			<li class="team-publications-filter__item">
				<a
					class="team-publications-filter__link<?php echo $is_active ? ' is-active' : ''; ?>"
					href="<?php echo esc_url( $link ); ?>"
					<?php echo $is_active ? 'aria-current="page"' : ''; ?>
				>
					<?php echo esc_html( $year ); ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</nav>
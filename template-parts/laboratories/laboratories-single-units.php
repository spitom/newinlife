<?php
/**
 * Laboratory units / pracownie.
 *
 * @package newinlife
 */

defined( 'ABSPATH' ) || exit;

$units = isset( $args['units'] ) && is_array( $args['units'] )
	? $args['units']
	: array();

if ( empty( $units ) ) {
	return;
}

$prepared_units = array();

$used_unit_keys = array();

foreach ( $units as $unit ) {
	if ( ! is_array( $unit ) ) {
		continue;
	}

	$title = isset( $unit['unit_title'] )
		? trim( (string) $unit['unit_title'] )
		: '';

	if ( '' === $title ) {
		continue;
	}

    $unit_key = sanitize_title( wp_strip_all_tags( $title ) );
    $base_unit_key = $unit_key;
    $suffix        = 2;

    while ( in_array( $unit_key, $used_unit_keys, true ) ) {
        $unit_key = $base_unit_key . '-' . $suffix;
        $suffix++;
    }

    $used_unit_keys[] = $unit_key;

	$tab_label = isset( $unit['unit_tab_label'] )
		? trim( (string) $unit['unit_tab_label'] )
		: '';

	$prepared_units[] = array(
        'key'       => $unit_key,
        'title'     => $title,
        'tab_label' => '' !== $tab_label ? $tab_label : wp_strip_all_tags( $title ),
        'intro'     => isset( $unit['unit_intro'] ) ? (string) $unit['unit_intro'] : '',
        'sections'  => isset( $unit['unit_sections'] ) && is_array( $unit['unit_sections'] )
            ? $unit['unit_sections']
            : array(),
    );
}

if ( empty( $prepared_units ) ) {
	return;
}

$tabs_id = 'laboratory-units-' . get_the_ID();
?>

<div class="lab-units" data-inlife-tabs>
	<header class="section-heading">
		<h2 class="section-title">
			<?php echo esc_html( inlife_t( 'Pracownie' ) ); ?>
		</h2>
	</header>

	<nav
		class="lab-units-nav"
		role="tablist"
		aria-label="<?php echo esc_attr( inlife_t( 'Nawigacja pracowni laboratorium' ) ); ?>"
	>
		<?php foreach ( $prepared_units as $index => $unit ) : ?>
			<?php
            $unit_key  = $unit['key'];
            $tab_id    = $tabs_id . '-tab-' . $unit_key;
            $panel_id = $tabs_id . '-panel-' . $unit_key;
            $is_active = 0 === $index;
            ?>
			<button
				type="button"
				id="<?php echo esc_attr( $tab_id ); ?>"
				class="lab-units-nav__btn<?php echo $is_active ? ' is-active' : ''; ?>"
				role="tab"
				aria-controls="<?php echo esc_attr( $panel_id ); ?>"
				aria-selected="<?php echo $is_active ? 'true' : 'false'; ?>"
				tabindex="<?php echo $is_active ? '0' : '-1'; ?>"
				data-inlife-tab-trigger="<?php echo esc_attr( $unit_key ); ?>"
			>
				<?php echo esc_html( $unit['tab_label'] ); ?>
			</button>
		<?php endforeach; ?>
	</nav>

    <div class="lab-units-panels">
        <?php foreach ( $prepared_units as $index => $unit ) : ?>
            <?php
            $unit_key  = $unit['key'];
            $tab_id    = $tabs_id . '-tab-' . $unit_key;
            $panel_id = $tabs_id . '-panel-' . $unit_key;
            $is_active = 0 === $index;
            ?>
            <span
                id="<?php echo esc_attr( $unit_key ); ?>"
                class="lab-units-panel-anchor"
                aria-hidden="true"
            ></span>
            <section
                id="<?php echo esc_attr( $panel_id ); ?>"
                class="lab-units-panel<?php echo $is_active ? ' is-active' : ''; ?>"
                role="tabpanel"
                aria-labelledby="<?php echo esc_attr( $tab_id ); ?>"
                tabindex="0"
                data-inlife-tab-panel="<?php echo esc_attr( $unit_key ); ?>"
                <?php echo $is_active ? '' : 'hidden'; ?>
            >
                <h3 class="lab-units-panel__title">
                    <?php
                    echo wp_kses(
                        $unit['title'],
                        array(
                            'em' => array(),
                        )
                    );
                    ?>
                </h3>

                <?php if ( '' !== trim( wp_strip_all_tags( $unit['intro'] ) ) ) : ?>
                    <div class="lab-units-panel__intro">
                        <?php echo wp_kses_post( $unit['intro'] ); ?>
                    </div>
                <?php endif; ?>

                <?php if ( ! empty( $unit['sections'] ) ) : ?>
                    <div class="lab-units-panel__sections">
                        <?php $section_number = 0; ?>
                        <?php foreach ( $unit['sections'] as $section ) : ?>
                            <?php
                            if ( ! is_array( $section ) ) {
                                continue;
                            }

                            $section_title = isset( $section['section_title'] )
                                ? trim( (string) $section['section_title'] )
                                : '';

                            $section_description = isset( $section['section_description'] )
                                ? (string) $section['section_description']
                                : '';

                            $section_offer = isset( $section['section_offer'] )
                                ? (string) $section['section_offer']
                                : '';

                            if (
                                '' === $section_title &&
                                '' === trim( wp_strip_all_tags( $section_description ) ) &&
                                '' === trim( wp_strip_all_tags( $section_offer ) )
                            ) {
                                continue;
                            }
                            $section_number++;
                            ?>

                            <div class="lab-unit-section">
                                <?php if ( '' !== $section_title ) : ?>
                                    <div class="lab-unit-section__heading">
                                        <span class="lab-unit-section__number" aria-hidden="true">
                                            <?php echo esc_html( str_pad( (string) $section_number, 2, '0', STR_PAD_LEFT ) ); ?>
                                        </span>

                                        <h4 class="lab-unit-section__title">
                                            <?php
                                            echo wp_kses(
                                                $section_title,
                                                array(
                                                    'em' => array(),
                                                )
                                            );
                                            ?>
                                        </h4>
                                    </div>
                                <?php endif; ?>

                                <div class="lab-unit-section__grid">
                                    <?php if ( '' !== trim( wp_strip_all_tags( $section_description ) ) ) : ?>
                                        <div class="lab-unit-section__description">
                                            <?php echo wp_kses_post( $section_description ); ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ( '' !== trim( wp_strip_all_tags( $section_offer ) ) ) : ?>
                                        <div class="lab-unit-section__offer">
                                            <h5 class="lab-unit-section__offer-title">
                                                <?php echo esc_html( inlife_t( 'Oferta pracowni' ) ); ?>
                                            </h5>

                                            <div class="lab-unit-section__offer-content">
                                                <?php echo wp_kses_post( $section_offer ); ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>
        <?php endforeach; ?>
    </div>
</div>

<?php
defined( 'ABSPATH' ) || exit;

$laboratory_id = get_the_ID();

$manager_id = function_exists( 'inlife_get_laboratory_manager' )
    ? (int) inlife_get_laboratory_manager( $laboratory_id )
    : 0;

$members = function_exists( 'inlife_get_laboratory_members' )
    ? inlife_get_laboratory_members( $laboratory_id )
    : array();

if ( ! is_array( $members ) ) {
    $members = array();
}

/**
 * Ensure manager is included in the members list if available.
 */
if ( $manager_id > 0 && ! in_array( $manager_id, array_map( 'intval', $members ), true ) ) {
    $members[] = $manager_id;
}

/**
 * OPTYMALIZACJA: Cache'ujemy wagi stanowisk przed sortowaniem, 
 * aby nie odpytywać bazy danych przez get_field() setki razy w usort.
 */
$member_weights = array();
$member_names   = array();

foreach ( $members as $m_id ) {
    $m_id = (int) $m_id;
    
    // Pobieramy stanowisko raz dla każdego użytkownika
    $position = function_exists( 'get_field' ) ? (string) get_field( 'person_position', $m_id ) : '';
    
    if ( '' === $position ) {
        $member_weights[ $m_id ] = 999;
    } else {
        $position = wp_strip_all_tags( $position );
        $position = remove_accents( mb_strtolower( $position ) );

        $map = array(

            'profesor instytutu'  => 15,
            'profesor'            => 10,
            'adiunkt'             => 20,
            'asystent'            => 30,
            'st. specjalist'      => 35,
            'st specjalist'       => 35,
            'starszy specjalist'  => 35,
            'specjalist'          => 40,
            'technolog'           => 50,
            'doktorant'           => 60,
        );

        $weight = 999;

        foreach ( $map as $needle => $w ) {
            if ( false !== strpos( $position, $needle ) ) {
                $weight = $w;
                break;
            }
        }
        $member_weights[ $m_id ] = $weight;
    }

    // Pobieramy imię i nazwisko raz
    $member_names[ $m_id ] = function_exists( 'inlife_get_person_display_name' )
        ? inlife_get_person_display_name( $m_id )
        : get_the_title( $m_id );
}

/**
 * Bezpieczne i błyskawiczne sortowanie na przygotowanej wcześniej tablicy danych
 */
if ( ! empty( $members ) ) {
    usort(
        $members,
        static function ( $a, $b ) use ( $manager_id, $member_weights, $member_names ) {
            $a = (int) $a;
            $b = (int) $b;

            if ( $manager_id > 0 ) {
                if ( $a === $manager_id ) {
                    return -1;
                }
                if ( $b === $manager_id ) {
                    return 1;
                }
            }

            $weight_a = $member_weights[$a] ?? 999;
            $weight_b = $member_weights[$b] ?? 999;

            if ( $weight_a !== $weight_b ) {
                return $weight_a <=> $weight_b;
            }

            $name_a = $member_names[$a] ?? '';
            $name_b = $member_names[$b] ?? '';

            return strcasecmp( $name_a, $name_b );
        }
    );
}
?>

<section class="lab-members-section" aria-labelledby="lab-members-title">
    <header class="section-heading">
        <h2 id="lab-members-title" class="section-title">
            <?php echo esc_html( inlife_t( 'Skład osobowy' ) ); ?>
        </h2>
    </header>

    <?php if ( ! empty( $members ) ) : ?>

        <div class="lab-members-list">
            <?php foreach ( $members as $member_id ) : ?>
                <?php
                $member_id = (int) $member_id;

                // Używamy pobranej wcześniej wartości name
                $name = $member_names[ $member_id ] ?? get_the_title( $member_id );

                $position     = function_exists( 'get_field' ) ? get_field( 'person_position', $member_id ) : '';
                
                // POPRAWKA: Rzutowanie na string (string), aby uniknąć błędów Deprecated dla wartości null
                $email        = function_exists( 'get_field' ) ? (string) get_field( 'person_email', $member_id ) : '';
                $orcid        = function_exists( 'get_field' ) ? (string) get_field( 'person_orcid', $member_id ) : '';
                $researchgate = function_exists( 'get_field' ) ? (string) get_field( 'person_researchgate', $member_id ) : '';
                $linkedin     = function_exists( 'get_field' ) ? (string) get_field( 'person_linkedin', $member_id ) : '';
                $has_image    = has_post_thumbnail( $member_id );

                $is_manager = ( $manager_id > 0 && $member_id === $manager_id );
                ?>

                <article class="lab-member-tile<?php echo $is_manager ? ' lab-member-tile--manager' : ''; ?>">
                    
                    <div class="lab-member-tile__media">
                        <?php if ( $has_image ) : ?>
                            <?php
                            echo get_the_post_thumbnail(
                                $member_id,
                                'thumbnail',
                                array(
                                    'class'   => 'lab-member-tile__image',
                                    'loading' => 'lazy',
                                )
                            );
                            ?>
                        <?php else : ?>
                            <span class="lab-member-tile__placeholder" aria-hidden="true">
                                <i class="bi bi-person-fill"></i>
                            </span>
                        <?php endif; ?>
                    </div>              
                
                    <h3 class="lab-member-tile__name">
                        <span><?php echo esc_html( $name ); ?></span>

                        <?php if ( $is_manager ) : ?>
                            <span class="lab-member-tile__badge">
                                <?php echo esc_html( inlife_t( 'Kierownik' ) ); ?>
                            </span>
                        <?php endif; ?>
                    </h3>

                    <?php if ( $position ) : ?>
                        <p class="lab-member-tile__position">
                            <?php echo esc_html( $position ); ?>
                        </p>
                    <?php endif; ?>

                    <?php if ( ! empty( $email ) ) : ?>
                        <p class="lab-member-tile__meta">
                            <?php
                            echo inlife_render_obfuscated_email_link(
                                $email,
                                'lab-member-tile__email-link'
                            ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                            ?>
                        </p>
                    <?php endif; ?>

                    <?php if ( $orcid || $researchgate || $linkedin ) : ?>
                        <div class="team-person-socials team-person-socials--member" aria-label="<?php echo esc_attr( inlife_t( 'Profile naukowe i społecznościowe' ) ); ?>">
                            <?php if ( $orcid ) : ?>
                                <a class="team-person-socials__link team-person-socials__link--orcid" href="<?php echo esc_url( $orcid ); ?>" target="_blank" rel="noopener noreferrer" aria-label="ORCID">
                                    <span class="team-person-socials__icon" aria-hidden="true">iD</span>
                                    <span class="visually-hidden">ORCID</span>
                                </a>
                            <?php endif; ?>

                            <?php if ( $researchgate ) : ?>
                                <a class="team-person-socials__link team-person-socials__link--researchgate" href="<?php echo esc_url( $researchgate ); ?>" target="_blank" rel="noopener noreferrer" aria-label="ResearchGate">
                                    <span class="team-person-socials__icon" aria-hidden="true">R<sup>G</sup></span>
                                    <span class="visually-hidden">ResearchGate</span>
                                </a>
                            <?php endif; ?>

                            <?php if ( $linkedin ) : ?>
                                <a class="team-person-socials__link team-person-socials__link--linkedin" href="<?php echo esc_url( $linkedin ); ?>" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
                                    <span class="team-person-socials__icon" aria-hidden="true">
                                        <i class="bi bi-linkedin"></i>
                                    </span>
                                    <span class="visually-hidden">LinkedIn</span>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                </article>
            <?php endforeach; ?>
        </div>

    <?php else : ?>

        <div class="team-empty-state">
            <p><?php echo esc_html( inlife_t( 'Skład osobowy nie został jeszcze uzupełniony.' ) ); ?></p>
        </div>

    <?php endif; ?>
</section>
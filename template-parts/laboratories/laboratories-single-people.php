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
 * Sort:
 * 1. manager always first
 * 2. by position weight
 * 3. alphabetically
 */
if ( ! empty( $members ) ) {
	usort(
		$members,
		static function ( $a, $b ) use ( $manager_id ) {
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

			$get_weight = static function ( int $person_id ): int {
				$position = function_exists( 'get_field' )
					? (string) get_field( 'person_position', $person_id )
					: '';

				if ( '' === $position ) {
					return 999;
				}

				$position = wp_strip_all_tags( $position );
				$position = remove_accents( mb_strtolower( $position ) );

				$map = array(
					'profesor'   => 10,
					'adiunkt'    => 20,
					'asystent'   => 30,
					'specjalist' => 40,
					'technolog'  => 50,
					'doktorant'  => 60,
				);

				foreach ( $map as $needle => $weight ) {
					if ( false !== strpos( $position, $needle ) ) {
						return $weight;
					}
				}

				return 999;
			};

			$weight_a = $get_weight( $a );
			$weight_b = $get_weight( $b );

			if ( $weight_a !== $weight_b ) {
				return $weight_a <=> $weight_b;
			}

			$name_a = function_exists( 'inlife_get_person_display_name' )
				? inlife_get_person_display_name( $a )
				: get_the_title( $a );

			$name_b = function_exists( 'inlife_get_person_display_name' )
				? inlife_get_person_display_name( $b )
				: get_the_title( $b );

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

				$name = function_exists( 'inlife_get_person_display_name' )
					? inlife_get_person_display_name( $member_id )
					: get_the_title( $member_id );

				$link     = get_permalink( $member_id );
				$position = function_exists( 'get_field' ) ? get_field( 'person_position', $member_id ) : '';
				$email    = function_exists( 'get_field' ) ? get_field( 'person_email', $member_id ) : '';

				$is_manager = ( $manager_id > 0 && $member_id === $manager_id );
				?>

				<article class="lab-member-tile<?php echo $is_manager ? ' lab-member-tile--manager' : ''; ?>">
					<h3 class="lab-member-tile__name">
						<a href="<?php echo esc_url( $link ); ?>">
							<?php echo esc_html( $name ); ?>
						</a>

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

					<?php if ( $email ) : ?>
						<p class="lab-member-tile__meta">
							<a href="mailto:<?php echo esc_attr( antispambot( $email ) ); ?>">
								<?php echo esc_html( antispambot( $email ) ); ?>
							</a>
						</p>
					<?php endif; ?>

					<a href="<?php echo esc_url( $link ); ?>" class="lab-member-tile__cta c-readmore">
						<span class="c-readmore__label">
							<?php echo esc_html( inlife_t( 'Zobacz profil' ) ); ?>
						</span>
						<span class="c-readmore__icon" aria-hidden="true">→</span>
					</a>
				</article>
			<?php endforeach; ?>
		</div>

	<?php else : ?>

		<div class="team-empty-state">
			<p><?php echo esc_html( inlife_t( 'Skład osobowy nie został jeszcze uzupełniony.' ) ); ?></p>
		</div>

	<?php endif; ?>
</section>
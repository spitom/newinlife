<?php
defined( 'ABSPATH' ) || exit;

$manager_id = function_exists( 'inlife_get_laboratory_manager' )
	? inlife_get_laboratory_manager( get_the_ID() )
	: null;

$members = function_exists( 'inlife_get_laboratory_members' )
	? inlife_get_laboratory_members( get_the_ID() )
	: array();

if ( ! is_array( $members ) ) {
	$members = array();
}

if ( $manager_id ) {
	$members = array_values(
		array_filter(
			$members,
			static fn( $member_id ) => (int) $member_id !== (int) $manager_id
		)
	);
}

if ( ! empty( $members ) ) {
	usort(
		$members,
		static function ( $a, $b ) {
			$get_weight = static function ( $person_id ): int {
				$position = function_exists( 'get_field' )
					? (string) get_field( 'person_position', (int) $person_id )
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

			$weight_a = $get_weight( (int) $a );
			$weight_b = $get_weight( (int) $b );

			if ( $weight_a !== $weight_b ) {
				return $weight_a <=> $weight_b;
			}

			$name_a = function_exists( 'inlife_get_person_display_name' )
				? inlife_get_person_display_name( (int) $a )
				: get_the_title( (int) $a );

			$name_b = function_exists( 'inlife_get_person_display_name' )
				? inlife_get_person_display_name( (int) $b )
				: get_the_title( (int) $b );

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

	<?php if ( $manager_id || ! empty( $members ) ) : ?>

		<?php if ( $manager_id ) : ?>
			<?php
			$name = function_exists( 'inlife_get_person_display_name' )
				? inlife_get_person_display_name( $manager_id )
				: get_the_title( $manager_id );

			$link     = get_permalink( $manager_id );
			$position = function_exists( 'get_field' ) ? get_field( 'person_position', $manager_id ) : '';
			$email    = function_exists( 'get_field' ) ? get_field( 'person_email', $manager_id ) : '';
			?>

			<div class="lab-manager-brief">
				<h3 class="lab-manager-brief__name">
					<a href="<?php echo esc_url( $link ); ?>">
						<?php echo esc_html( $name ); ?>
					</a>
					<span class="lab-manager-brief__badge">
						<?php echo esc_html( inlife_t( 'Kierownik' ) ); ?>
					</span>
				</h3>

				<?php if ( $position ) : ?>
					<p class="lab-manager-brief__position">
						<?php echo esc_html( $position ); ?>
					</p>
				<?php endif; ?>

				<?php if ( $email ) : ?>
					<p class="lab-manager-brief__meta">
						<a href="mailto:<?php echo esc_attr( antispambot( $email ) ); ?>">
							<?php echo esc_html( antispambot( $email ) ); ?>
						</a>
					</p>
				<?php endif; ?>

				<a href="<?php echo esc_url( $link ); ?>" class="lab-manager-brief__cta c-readmore">
					<span class="c-readmore__label">
						<?php echo esc_html( inlife_t( 'Zobacz profil' ) ); ?>
					</span>
					<span class="c-readmore__icon" aria-hidden="true">→</span>
				</a>
			</div>
		<?php endif; ?>

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
					?>

					<article class="lab-member-tile">
						<h3 class="lab-member-tile__name">
							<a href="<?php echo esc_url( $link ); ?>">
								<?php echo esc_html( $name ); ?>
							</a>
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
		<?php endif; ?>

	<?php else : ?>

		<div class="team-empty-state">
			<p><?php echo esc_html( inlife_t( 'Skład osobowy nie został jeszcze uzupełniony.' ) ); ?></p>
		</div>

	<?php endif; ?>
</section>
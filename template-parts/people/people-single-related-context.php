<?php
defined( 'ABSPATH' ) || exit;

$post_id = get_the_ID();

$teams = get_field( 'team_memberships', $post_id );
$labs  = get_field( 'laboratory_memberships', $post_id );

if ( empty( $teams ) && empty( $labs ) ) {
	return;
}
?>

<div class="people-single-panel">
	<h2 class="people-single-panel__title">
		<?php esc_html_e( 'Powiązania', 'newinlife' ); ?>
	</h2>

	<?php if ( $teams ) : ?>
		<p><strong><?php esc_html_e( 'Zespoły:', 'newinlife' ); ?></strong></p>
		<ul>
			<?php foreach ( $teams as $row ) : 
				$team = $row['team'] ?? null;
				if ( ! $team ) continue;
			?>
				<li>
					<a href="<?php echo esc_url( get_permalink( $team ) ); ?>">
						<?php echo esc_html( get_the_title( $team ) ); ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>

	<?php if ( $labs ) : ?>
		<p><strong><?php esc_html_e( 'Laboratoria:', 'newinlife' ); ?></strong></p>
		<ul>
			<?php foreach ( $labs as $row ) : 
				$lab = $row['laboratory'] ?? null;
				if ( ! $lab ) continue;
			?>
				<li>
					<a href="<?php echo esc_url( get_permalink( $lab ) ); ?>">
						<?php echo esc_html( get_the_title( $lab ) ); ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>

</div>
<?php
defined( 'ABSPATH' ) || exit;

$current_search = get_query_var( 's' );
$current_type   = isset( $_GET['people_type'] ) ? sanitize_text_field( wp_unslash( $_GET['people_type'] ) ) : '';
$current_team   = isset( $_GET['team'] ) ? (int) $_GET['team'] : 0;
$current_lab    = isset( $_GET['lab'] ) ? (int) $_GET['lab'] : 0;

$archive_url = get_post_type_archive_link( 'people' );
?>

<form
	class="people-search c-search"
	method="get"
	action="<?php echo esc_url( $archive_url ); ?>"
	onsubmit="var input=this.querySelector('#people-search-input'); if(input && !input.value.trim()){ window.location=this.action; return false; }"
>
	<label class="visually-hidden" for="people-search-input">
		<?php echo esc_html( inlife_t( 'Szukaj osoby' ) ); ?>
	</label>

	<div class="people-search__inner c-search__inner">
		<input
			id="people-search-input"
			type="search"
			name="s"
			class="form-control people-search__input c-search__input"
			placeholder="<?php echo esc_attr( inlife_t( 'Szukaj osoby...' ) ); ?>"
			value="<?php echo esc_attr( $current_search ); ?>"
		>

		<input type="hidden" name="post_type" value="people">

		<?php if ( $current_type ) : ?>
			<input type="hidden" name="people_type" value="<?php echo esc_attr( $current_type ); ?>">
		<?php endif; ?>

		<?php if ( $current_team ) : ?>
			<input type="hidden" name="team" value="<?php echo esc_attr( $current_team ); ?>">
		<?php endif; ?>

		<?php if ( $current_lab ) : ?>
			<input type="hidden" name="lab" value="<?php echo esc_attr( $current_lab ); ?>">
		<?php endif; ?>

		<button type="submit" class="btn btn-primary people-search__button c-search__button">
			<?php echo esc_html( inlife_t( 'Szukaj' ) ); ?>
		</button>
	</div>
</form>
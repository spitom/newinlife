<?php
/**
 * Teams archive header.
 *
 * @package newinlife
 */

defined( 'ABSPATH' ) || exit;

$hero_content = array(
	'all' => array(
		'kicker'      => inlife_t( 'Badania' ),
		'title'       => inlife_t( 'Zespoły badawcze' ),
		'description' => inlife_t( 'Poznaj zespoły badawcze realizujące projekty w obszarach żywności, zdrowia oraz nauk o zwierzętach.' ),
	),
	'zwierzeta' => array(
		'kicker'      => inlife_t( 'Badania' ),
		'title'       => inlife_t( 'Zespoły badawcze' ),
		'description' => inlife_t( 'Nauki o zwierzętach – badania nad biologią zwierząt oraz nad metodami ich hodowli, rozrodu, żywienia i zarządzania.' ),
	),
	'zywnosc' => array(
		'kicker'      => inlife_t( 'Badania' ),
		'title'       => inlife_t( 'Zespoły badawcze' ),
		'description' => inlife_t( 'Nauki o żywności – badania nad składem, właściwościami i jakością żywności oraz wpływem składników odżywczych i bioaktywnych na zdrowie człowieka.' ),
	),
	'zdrowie' => array(
		'kicker'      => inlife_t( 'Badania' ),
		'title'       => inlife_t( 'Zespoły badawcze' ),
		'description' => inlife_t( 'Nauki o zdrowiu – badania nad mechanizmami warunkującymi zdrowie i chorobę oraz nad biologicznymi podstawami profilaktyki, diagnostyki i terapii.' ),
	),
);
?>

<section class="teams-archive-header section">
	<div class="container">
		<header
			class="teams-archive-header__content"
			id="teamsArchiveHero"
			data-current-area="all"
		>
			<p class="section-eyebrow teams-archive-header__eyebrow" id="teamsArchiveHeroKicker">
				<?php echo esc_html( $hero_content['all']['kicker'] ); ?>
			</p>

			<h1 class="section-title teams-archive-header__title" id="teamsArchiveHeroTitle">
				<?php echo esc_html( $hero_content['all']['title'] ); ?>
			</h1>

			<p class="section-lead teams-archive-header__lead" id="teamsArchiveHeroDescription">
				<?php echo esc_html( $hero_content['all']['description'] ); ?>
			</p>
		</header>
	</div>
</section>

<script type="application/json" id="teamsArchiveHeroData">
<?php echo wp_json_encode( $hero_content, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ); ?>
</script>
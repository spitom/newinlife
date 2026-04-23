<?php
/**
 * Archive template for Teams.
 *
 * @package newinlife
 */

defined( 'ABSPATH' ) || exit;

get_header();

$hero_content = [
	'all' => [
		'kicker'      => inlife_t( 'Badania' ),
		'title'       => inlife_t( 'Zespoły badawcze' ),
		'description' => inlife_t( 'Poznaj zespoły badawcze realizujące projekty w obszarach żywności, zdrowia oraz nauk o zwierzętach.' ),
	],
	'zwierzeta' => [
		'kicker'      => inlife_t( 'Badania' ),
		'title'       => inlife_t( 'Zespoły badawcze' ),
		'description' => inlife_t( 'Nauki o zwierzętach – badania nad biologią zwierząt oraz nad metodami ich hodowli, rozrodu, żywienia i zarządzania.' ),
	],
	'zywnosc' => [
		'kicker'      => inlife_t( 'Badania' ),
		'title'       => inlife_t( 'Zespoły badawcze' ),
		'description' => inlife_t( 'Nauki o żywności – badania nad składem, właściwościami i jakością żywności oraz wpływem składników odżywczych i bioaktywnych na zdrowie człowieka.' ),
	],
	'zdrowie' => [
		'kicker'      => inlife_t( 'Badania' ),
		'title'       => inlife_t( 'Zespoły badawcze' ),
		'description' => inlife_t( 'Nauki o zdrowiu – badania nad mechanizmami warunkującymi zdrowie i chorobę oraz nad biologicznymi podstawami profilaktyki, diagnostyki i terapii.' ),
	],
];
?>

<main id="main-content" class="site-main site-main--teams">

	<section class="page-section page-section--teams-hero">
		<?php
		get_template_part(
			'template-parts/patterns/pattern',
			'page-hero',
			[
				'kicker'      => $hero_content['all']['kicker'],
				'title'       => $hero_content['all']['title'],
				'lead'        => $hero_content['all']['description'],
				'breadcrumbs' => true,
				'modifier'    => 'flush',

				'section_id' => 'teamsArchiveHero',
				'data_attrs' => [
					'current-area' => 'all',
				],
				'kicker_id' => 'teamsArchiveHeroKicker',
				'title_id'  => 'teamsArchiveHeroTitle',
				'lead_id'   => 'teamsArchiveHeroDescription',
			]
		);
		?>
	</section>

	<?php get_template_part( 'template-parts/teams/teams-archive', 'area-nav' ); ?>
	<?php get_template_part( 'template-parts/teams/teams-archive', 'sections' ); ?>

</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
	const hero = document.querySelector('.js-teams-archive-hero');

	if (!hero) {
		return;
	}

	hero.id = 'teamsArchiveHero';
	hero.setAttribute('data-current-area', 'all');

	const kicker = hero.querySelector('.p-page-hero__kicker');
	const title = hero.querySelector('.p-page-hero__title');
	const lead = hero.querySelector('.p-page-hero__lead');

	if (kicker) {
		kicker.id = 'teamsArchiveHeroKicker';
	}

	if (title) {
		title.id = 'teamsArchiveHeroTitle';
	}

	if (lead) {
		lead.id = 'teamsArchiveHeroDescription';
	}
});
</script>

<script type="application/json" id="teamsArchiveHeroData">
<?php echo wp_json_encode( $hero_content, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ); ?>
</script>

<?php
get_footer();
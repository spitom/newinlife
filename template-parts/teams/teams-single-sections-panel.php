<?php
defined( 'ABSPATH' ) || exit;
?>

<div class="team-sections-panel" data-team-panels>

	<section
		id="team-panel-badania"
		class="team-sections-panel__item is-active"
		data-team-panel-content="badania"
	>
		<?php get_template_part( 'template-parts/teams/teams-single-section', 'research' ); ?>
	</section>

	<section
		id="team-panel-projekty"
		class="team-sections-panel__item"
		data-team-panel-content="projekty"
		hidden
	>
		<?php get_template_part( 'template-parts/teams/teams-single-section', 'projects' ); ?>
	</section>

	<section
		id="team-panel-publikacje"
		class="team-sections-panel__item"
		data-team-panel-content="publikacje"
		hidden
	>
		<?php get_template_part( 'template-parts/teams/teams-single-section', 'publications' ); ?>
	</section>

	<section
		id="team-panel-aktualnosci"
		class="team-sections-panel__item"
		data-team-panel-content="aktualnosci"
		hidden
	>
		<?php get_template_part( 'template-parts/teams/teams-single-section', 'news' ); ?>
	</section>

</div>
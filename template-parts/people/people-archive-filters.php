<section class="people-filters section">
	<div class="container">

		<form method="get" class="people-filters__form">

			<select name="type">
				<option value="">Typ osoby</option>
				<option value="scientific">Naukowy</option>
				<option value="staff">Pracownik</option>
			</select>

			<select name="team">
				<option value="">Zespół</option>
				<?php
				$teams = get_posts(['post_type'=>'teams','posts_per_page'=>-1]);
				foreach ($teams as $team) :
				?>
					<option value="<?php echo $team->ID; ?>">
						<?php echo esc_html($team->post_title); ?>
					</option>
				<?php endforeach; ?>
			</select>

			<select name="lab">
				<option value="">Laboratorium</option>
				<?php
				$labs = get_posts(['post_type'=>'laboratories','posts_per_page'=>-1]);
				foreach ($labs as $lab) :
				?>
					<option value="<?php echo $lab->ID; ?>">
						<?php echo esc_html($lab->post_title); ?>
					</option>
				<?php endforeach; ?>
			</select>

			<button type="submit" class="btn btn-primary">
				Filtruj
			</button>

		</form>

	</div>
</section>
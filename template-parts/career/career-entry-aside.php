<?php
defined('ABSPATH') || exit;

$post_id = get_the_ID();

$unit            = function_exists('inlife_get_acf_field') ? inlife_get_acf_field('career_unit', $post_id, '') : '';
$project_name    = function_exists('inlife_get_acf_field') ? inlife_get_acf_field('career_project_name', $post_id, '') : '';
$employment_type = function_exists('inlife_get_acf_field') ? inlife_get_acf_field('career_employment_type', $post_id, '') : '';
$location_text   = function_exists('inlife_get_acf_field') ? inlife_get_acf_field('career_location_text', $post_id, '') : '';
$contact_email   = function_exists('inlife_get_acf_field') ? inlife_get_acf_field('career_contact_email', $post_id, '') : '';
$contact_phone   = function_exists('inlife_get_acf_field') ? inlife_get_acf_field('career_contact_phone', $post_id, '') : '';
$contact_person  = function_exists('inlife_get_acf_field') ? inlife_get_acf_field('career_contact_person', $post_id, '') : '';
$application_url = function_exists('inlife_get_acf_field') ? inlife_get_acf_field('career_application_url', $post_id, '') : '';
?>

<?php if ($unit || $project_name || $employment_type || $location_text || $contact_email || $contact_phone || $contact_person || $application_url) : ?>
	<div class="career-entry-panel">
		<h2 class="career-entry-panel__title">Informacje podstawowe</h2>

		<?php if ($unit) : ?>
			<p class="career-entry-panel__text"><strong>Jednostka:</strong> <?php echo esc_html($unit); ?></p>
		<?php endif; ?>

		<?php if ($project_name) : ?>
			<p class="career-entry-panel__text"><strong>Projekt:</strong> <?php echo esc_html($project_name); ?></p>
		<?php endif; ?>

		<?php if ($employment_type) : ?>
			<p class="career-entry-panel__text"><strong>Forma współpracy:</strong> <?php echo esc_html($employment_type); ?></p>
		<?php endif; ?>

		<?php if ($location_text) : ?>
			<p class="career-entry-panel__text"><strong>Miejsce:</strong> <?php echo esc_html($location_text); ?></p>
		<?php endif; ?>

		<?php if ($contact_person) : ?>
			<p class="career-entry-panel__text"><strong>Kontakt:</strong> <?php echo esc_html($contact_person); ?></p>
		<?php endif; ?>

		<?php if ($contact_email) : ?>
			<p class="career-entry-panel__text">
				<a href="mailto:<?php echo esc_attr(antispambot($contact_email)); ?>">
					<?php echo esc_html(antispambot($contact_email)); ?>
				</a>
			</p>
		<?php endif; ?>

		<?php if ($contact_phone) : ?>
			<p class="career-entry-panel__text">
				<a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $contact_phone)); ?>">
					<?php echo esc_html($contact_phone); ?>
				</a>
			</p>
		<?php endif; ?>

		<?php if ($application_url) : ?>
			<p class="career-entry-panel__actions">
				<a class="btn btn-primary" href="<?php echo esc_url($application_url); ?>">
					Przejdź do aplikacji
				</a>
			</p>
		<?php endif; ?>
	</div>
<?php endif; ?>

<?php if (function_exists('get_field')) : ?>
	<?php $attachments = get_field('career_attachment_files', $post_id); ?>

	<?php if (!empty($attachments) && is_array($attachments)) : ?>
		<div class="career-entry-panel">
			<h2 class="career-entry-panel__title">Załączniki</h2>

			<ul class="career-entry-files">
				<?php foreach ($attachments as $attachment) : ?>
					<?php
					$file = $attachment['file_asset'] ?? null;
					$file_title = $attachment['file_title'] ?? '';
					$file_url = is_array($file) && !empty($file['url']) ? $file['url'] : '';
					?>
					<?php if ($file_url) : ?>
						<li class="career-entry-files__item">
							<a href="<?php echo esc_url($file_url); ?>">
								<?php echo esc_html($file_title ?: basename($file_url)); ?>
							</a>
						</li>
					<?php endif; ?>
				<?php endforeach; ?>
			</ul>
		</div>
	<?php endif; ?>
<?php endif; ?>
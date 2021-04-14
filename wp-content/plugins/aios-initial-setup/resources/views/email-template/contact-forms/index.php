<?php
	$forms_query = new WP_Query([
    'post_type' => 'wpcf7_contact_form',
    'posts_per_page' => -1,
    'orderby' => 'title',
    'order' => 'ASC'
  ]);
	$forms = [];

	if ($forms_query->have_posts()) {
		while ($forms_query->have_posts()) {
			$forms_query->the_post();
			$form_id = get_the_ID();
			$form_title = trim(preg_replace('/\s*\([^)]*\)/', '', get_the_title()));
			$forms[$form_id] = $form_title;
		}
	}

	array_filter($forms);

	$aios_disable_email_templates_from = $options['disabled_form_templates'];

	echo AIOS_CREATE_FIELDS::input_field([
		'row_title' => 'Disable Template',
		'name' => 'aios_disable_email_templates_from',
		'options' => $forms,
		'value' => $aios_disable_email_templates_from,
		'type' => 'checkbox',
		'helper_value' => 'When checkbox is checked it will disable sending custom template to user and client confirmation.',
    'toggle_ui' => true
	]);
?>

<div class="wpui-row wpui-row-submit">
	<div class="wpui-col-md-12">
		<div class="form-group">
			<input type="submit" class="save-option-ajax wpui-secondary-button text-uppercase" value="Save Changes">
		</div>
	</div>
</div>

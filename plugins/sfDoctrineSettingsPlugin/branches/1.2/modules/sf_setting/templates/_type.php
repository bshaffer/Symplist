<?php use_helper('Form') ?>
<?php
$options = array('checkbox' =>  'Checkbox',
                 'input'    =>  'Text Field',
                 'textarea' =>  'Text Area',
                 'wysiwyg'  =>  'Rich Text Area',
                 'yesno'    =>  'Yes/No Radios',
                 'model'    =>  'Doctrine Model Select',
                 'select'   =>  'Select');

$options = options_for_select($options, $form->getObject()->getType(), 'include_blank=true');
?>
<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_type">
        <div>
      <label for="sf_setting_name">Type</label>
			<?php echo select_tag('sf_setting[type]', $options); ?>
          </div>
  </div>


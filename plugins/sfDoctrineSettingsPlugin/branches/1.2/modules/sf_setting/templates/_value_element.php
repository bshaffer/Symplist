<?php use_helper('Form') ?>
<?php use_helper('Object') ?>
<?php 
$type = $sf_setting->getType();
$name = isset($name) ? $name:'sf_setting[value]';

switch($type)
{
  case 'checkbox':
    echo input_hidden_tag($name, 0);
    echo checkbox_tag($name, 1, $sf_setting->getValue());
  break;

  case 'input':
    echo input_tag($name, $sf_setting->getValue(), 'size=55');
  break;

  case 'textarea':
    echo textarea_tag($name, $sf_setting->getValue());
  break;

  case 'yesno':
    echo 'Yes: '.radiobutton_tag($name, 1, $sf_setting->getValue());
    echo 'No: '.radiobutton_tag($name, 0, $sf_setting->getValue() ? false:true);
  break;

  case 'select':
    $options = _parse_attributes($sf_setting->getOptions());
    echo select_tag($name, options_for_select($options, $sf_setting->getValue(), 'include_blank=true'));
  break;

  case 'model':
    $config = _parse_attributes($sf_setting->getOptions());
		$method = isset($config['table_method']) ? $config['table_method'] : 'findAll';
		$options = Doctrine::getTable($config['model'])->$method(); 
		echo select_tag($name, objects_for_select($options, 'getId', '__toString', $sf_setting->getValue()), 'include_blank=true');
  break;

  case 'wysiwyg':
    echo textarea_tag($name, $sf_setting->getvalue(), 'rich=true '.$sf_setting->getOptions());
  break;

  case 'upload':
		echo $sf_setting->getValue() ? link_to($sf_setting->getValue(), public_path('uploads/setting/'.$sf_setting->getValue())) .'<br />' : '';
    echo input_file_tag($name, $sf_setting->getValue(), $sf_setting->getOptions());
  break;

	default:
    echo input_tag($name, $sf_setting->getValue(), 'size=55');
	break;
}

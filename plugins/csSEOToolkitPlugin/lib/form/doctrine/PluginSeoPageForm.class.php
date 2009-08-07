<?php

/**
 * PluginSeoPage form.
 *
 * @package    form
 * @subpackage SeoPage
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
abstract class PluginSeoPageForm extends BaseSeoPageForm
{
	public function setUp()
	{
		parent::setUp();
		$this->hideField('url');
		$this->widgetSchema['title'] = new sfWidgetFormInput(array(), array('size' => 40));
		$this->widgetSchema['description'] = new sfWidgetFormTextarea(array(), array('cols' => 38));
		$this->widgetSchema['keywords'] = new sfWidgetFormInput(array(), array('size' => 40));
	}
	public function hideField($field)
	{
		$this->widgetSchema[$field] = new sfWidgetFormInputHidden();
	}
	public function hideFields($fields = array())
	{
		foreach ($fields as $field) 
		{
			$this->hideField($field);
		}
	}
}
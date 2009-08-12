<?php

/**
 * SymfonyPlugin form.
 *
 * @package    plugintracker
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id$
 */
class SymfonyPluginForm extends BaseSymfonyPluginForm
{
  public function configure()
  {
    unset($this['created_at'], $this['updated_at'], $this['slug']);    
    $this->widgetSchema['user_id']        = new sfWidgetFormInputHidden();
    $this->widgetSchema['category_id']    = new sfWidgetFormDoctrineChoice(array('model' => 'PluginCategory', 'add_empty' => false));
    
    $this->widgetSchema->setLabel('category_id', 'Category');
    $this->widgetSchema->setHelp('repository_url', 'If left blank, the repository url will automatically point to the symfony repository with your plugin title (ex: http://svn.symfony-project.com/plugins/sfMyFakePlugin)');
    $this->setDefault('active', true);
    
    $this->validatorSchema['category_id']  = new sfValidatorDoctrineChoice(array('model' => 'PluginCategory', 'required' => false));
  }
  public function setDefaultWidgets()
  {
    // do nothing, overriding BaseFormDoctrine method
  }
}

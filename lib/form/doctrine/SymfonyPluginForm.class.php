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
    unset($this['created_at'], $this['updated_at'], $this['slug'], $this['raters_list'], $this['symfony_developer'], $this['authors_list'], $this['active']);

    $this->widgetSchema['category_id']    = new sfWidgetFormDoctrineChoice(array(
                        'model' => 'PluginCategory', 
                        'add_empty' => false, 
                        'query' => Doctrine::getTable('PluginCategory')->createQuery()->orderBy('name ASC')
                      ));
                      
    $this->setImageField('symfony_plugin', 'image');
    
    $tags = Doctrine::getTable('Tag')->createQuery()->orderBy('name ASC')->execute();
    $this->widgetSchema['tags_list'] = new sfWidgetFormSelectDoubleList($this->getDoubleListArray($tags->toKeyValueArray('id', 'name')));
    
    $this->widgetSchema->setLabel('category_id', 'Category');
    $this->widgetSchema->setHelp('repository', 'If left blank, the repository url will automatically point to the symfony repository with your plugin title <span class="example-text">(http://svn.symfony-project.com/plugins/sfMyFakePlugin)</span>');
    $this->setDefault('active', true);

    $this->validatorSchema['category_id']  = new sfValidatorDoctrineChoice(array('model' => 'PluginCategory', 'required' => false));
    $this->validatorSchema['repository']  = new sfValidatorUrl(array('required' => false));
    $this->validatorSchema['ticketing']  = new sfValidatorUrl(array('required' => false));
    $this->validatorSchema['homepage']  = new sfValidatorUrl(array('required' => false));  
        
  }
  public function setDefaultWidgets()
  {
    // do nothing, overriding BaseFormDoctrine method
  }
}

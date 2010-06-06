<?php

/**
 * PluginRelease form.
 *
 * @package    form
 * @subpackage PluginRelease
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class PluginReleaseForm extends BasePluginReleaseForm
{
  public function configure()
  {
    $this->useFields(array(
        'version',
        'summary',
        'stability',
        'api_versions_list',
        'dependencies',
      ));
    
    if ($plugin = $this->getOption('plugin')) 
    {
      $this->widgetSchema['plugin_id'] = new sfWidgetFormInputHidden();
      $this->setDefault('plugin_id', $plugin->id);
    }
    
    $this->setDefault('date', date('Y-m-d H:i:s'));
    $this->widgetSchema['date'] = new sfWidgetFormInputHidden();
    
    $apiVersions = Doctrine::getTable('SymfonyApiVersion')->findAll();
    $choices = $apiVersions->toKeyValueArray('id', 'name');
    $this->widgetSchema['api_versions_list'] = new sfWidgetFormChoice(array('choices' => $choices, 'multiple' => true, 'expanded' => true));
    
    $this->widgetSchema->setLabels(array(
        'api_versions_list'   => 'Api Versions',
      ));
      
    $this->widgetSchema['dependencies'] => new sfWidgetFormAjax('')
  }
}
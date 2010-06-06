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
      ));
    
    if ($plugin = $this->getOption('plugin')) 
    {
      $this->widgetSchema['plugin_id'] = new sfWidgetFormInputHidden();
      $this->setDefault('plugin_id', $plugin->id);
    }
    
    $this->setDefault('date', date('Y-m-d H:i:s'));

    $this->validatorSchema['version'] = new sfValidatorVersion();
    
    $apiVersions = Doctrine::getTable('SymfonyApiVersion')->findAll();
    $choices = $apiVersions->toKeyValueArray('id', 'name');
    
    $this->mergeWidgets(array(
        'date'              => new sfWidgetFormInputHidden(),
        'api_versions_list' => new sfWidgetFormChoice(array('choices' => $choices, 'multiple' => true, 'expanded' => true)),
      ));

    // Embed Dependencies
    $dependencyForm = new sfForm();
    foreach ($this->object['Dependencies'] as $i => $dependency) 
    {
      $dependencyForm->embedForm('dependency_'.$i, new PluginReleaseDependencyForm($dependency));
    }
    $this->embedForm('dependencies', $dependencyForm);
    
    // Set Labels
    $this->widgetSchema->setLabels(array(
        'api_versions_list'   => 'Api Versions',
      ));
    
  }
}
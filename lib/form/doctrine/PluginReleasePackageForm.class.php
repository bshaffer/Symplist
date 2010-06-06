<?php

/**
* 
*/
class PluginReleasePackageForm extends BaseForm
{
  public function configure()
  {
    $this->setWidgets(array(
        'url'       => new sfWidgetFormInput(),
        'file'      => new sfWidgetFormInputFile(),
      ));
      
    $this->setValidators(array(
        'url'       => new sfValidatorUrl(array('required' => false, 'protocols' => array('http', 'https', 'ftp', 'ftps', 'git', 'svn'))),
        'file'      => new sfValidatorFile(array('required' => false)),
      ));
      
    $this->widgetSchema->setLabels(array(
        'url'       => 'by url',
        'file'      => 'or by file'
      ));
      
    $this->widgetSchema->setHelps(array(
        'url'       => 'Use a url to an SVN or GIT repository',
        'file'      => 'upload a compressed file containing all the resources for your plugin release',
      ));
      
    $this->validatorSchema->setPreValidator(new sfValidatorSchemaRequired(null, array('max_required' => 1)));
    
    $this->widgetSchema->setNameFormat('package[%s]');
  }
}

<?php

class CommentFormGenerator extends sfDoctrineFormGenerator
{
  protected $_options = array('commentClass'      => 'Comment',
                              'commentAlias'      => 'Comments',
                              'className'         => '%CLASS%CommentForm',
                              'local'             => 'id',
                              'generateFiles'     => true,
    );
    
  protected function loadModels()
  {
    return array('NewsComment');
  }    

  public function setUp()
  {
    // generate this form
    $generatorManager = new sfGeneratorManager(ProjectConfiguration::getApplicationConfiguration('backend', 'dev', true));
    $generatorManager->generate('sfDoctrineFormGenerator', array(
        'connection'     => 'doctrine',
        'model_dir_name' => 'model',
        'form_dir_name'  => 'form',
    ));
    $generator = new CommentFormGenerator($generatorManager);
    $generator->generate(array('connection' => 'doctrine'));
    
  }

  /**
   * Generates classes and templates in cache.
   *
   * @param array The parameters
   *
   * @return string The data to put in configuration cache
   */
  public function generate($params = array())
  {
    $this->params = $params;

    if (!isset($this->params['connection']))
    {
      throw new sfParseException('You must specify a "connection" parameter.');
    }

    if (!isset($this->params['model_dir_name']))
    {
      $this->params['model_dir_name'] = 'model';
    }

    if (!isset($this->params['form_dir_name']))
    {
      $this->params['form_dir_name'] = 'form';
    }
    
    $models = $this->loadModels();
    
    // create the project base class for all forms
    $file = sfConfig::get('sf_lib_dir').'/form/doctrine/BaseFormDoctrine.class.php';
    if (!file_exists($file))
    {
      if (!is_dir(sfConfig::get('sf_lib_dir').'/form/doctrine/base'))
      {
        mkdir(sfConfig::get('sf_lib_dir').'/form/doctrine/base', 0777, true);
      }

      file_put_contents($file, $this->evalTemplate('sfDoctrineFormBaseTemplate.php'));
    }

    $pluginPaths = $this->generatorManager->getConfiguration()->getAllPluginPaths();

    // create a form class for every Doctrine class
    foreach ($models as $model)
    {
      $this->table = Doctrine::getTable($model);
      $this->modelName = $model;

      $baseDir = sfConfig::get('sf_lib_dir') . '/form/doctrine';

      $isPluginModel = $this->isPluginModel($model);
      if ($isPluginModel)
      {
        $pluginName = $this->getPluginNameForModel($model);

        $baseDir .= '/' . $pluginName;
      }

      if (!is_dir($baseDir.'/base'))
      {
        mkdir($baseDir.'/base', 0777, true);
      }

      file_put_contents($baseDir.'/base/Base'.$model.'Form.class.php', $this->evalTemplate('sfDoctrineFormGeneratedTemplate.php'));

      if ($isPluginModel)
      {
        $pluginBaseDir = $pluginPaths[$pluginName].'/lib/form/doctrine';
        if (!file_exists($classFile = $pluginBaseDir.'/Plugin'.$model.'Form.class.php'))
        {
            if (!is_dir($pluginBaseDir))
            {
              mkdir($pluginBaseDir, 0777, true);
            }
            file_put_contents($classFile, $this->evalTemplate('sfDoctrineFormPluginTemplate.php'));
        }
      }
      if (!file_exists($classFile = $baseDir.'/'.$model.'Form.class.php'))
      {
        if ($isPluginModel)
        {
           file_put_contents($classFile, $this->evalTemplate('sfDoctrinePluginFormTemplate.php'));
        } else {
           file_put_contents($classFile, $this->evalTemplate('sfDoctrineFormTemplate.php'));
        }
      }
    }

  }
  public function isPluginModel($model)
  {
    return true;
  }
  
  public function getManyToManyRelations()
  {
    return array();
  }
  
  public function getColumnNameMaxLength()
  {
    return 400;
  }
}
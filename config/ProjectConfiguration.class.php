<?php

require_once dirname(__FILE__).'/../lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    sfYaml::setSpecVersion('1.1');
    $this->enablePlugins(array(
      'sfDoctrinePlugin', 
      'csAdminGeneratorPlugin', 
      'csDoctrineActAsAttachablePlugin',
      'csDoctrineActAsSortablePlugin',
      'csDoctrineMarkdownPlugin',
      'csFormTransformPlugin',
      'csNavigationPlugin',
      'csSEOToolkitPlugin',
      'csThumbnailPlugin',
      'sfCommentsPlugin',
      'sfDoctrineGuardPlugin',
      'sfDoctrineSettingsPlugin',
      'sfFormExtraPlugin',
      'sfGoogleAnalyticsPlugin',
      'sfGravatarPlugin',
      'sfJqueryReloadedPlugin',
      'sfLucenePlugin',
      'sfTaskExtraPlugin',
      ));

    $this->dispatcher->connect('request.filter_parameters', array($this, 'filterRequestParameters'));
    $this->dispatcher->connect('view.configure_format', array($this, 'configureMobileFormat'));
  }
 
  public function filterRequestParameters(sfEvent $event, $parameters)
  {
    $request = $event->getSubject();

    if (preg_match('#Mobile/.+Safari#i', $request->getHttpHeader('User-Agent'))) {
      $request->setRequestFormat('iphone');
    }
  
    // if (preg_match('#Mobile/.+Safari#i', $request->getHttpHeader('User-Agent'))) {
    //   $request->setRequestFormat('m');
    // }
   
    return $parameters;
  }
  
  public function configureMobileFormat(sfEvent $event)
  {
    
    // $event['request']->setRequestFormat('html');
    // if ('m' == $event['format']) {
    //   $view = $event->getSubject();
    //   $dir = sfConfig::get('sf_app_module_dir').'/'.$view->getModuleName().'/templates/'.$view->getActionName().$view->getViewName().$view->getExtension();
    // 
    //   if (!file_exists($dir)) {
    //     $view->setExtension('.php');
    //   }
    //   $event['request']->setRequestFormat('html');
    //   // $view->setDecoratorTemplate(false);
    // }
  }
}

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
    $this->dispatcher->connect('view.configure_format', array($this, 'configureIPhoneFormat'));
  }
 
  public function filterRequestParameters(sfEvent $event, $parameters)
  {
    $request = $event->getSubject();
 
    if (!$request->getHttpHeader('User-Agent'))
    {
      // This is being accessed via command line
      $request->setRequestFormat('api');
    }
 
    return $parameters;
  }

  public function configureIPhoneFormat(sfEvent $event)
  {
    if ('api' == $event['format'])
    {
      exit(get_class($event->getSubject()));
    }
  }
}

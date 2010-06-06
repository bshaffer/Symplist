<?php

require_once dirname(__FILE__).'/../lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    require_once dirname(__FILE__) . '/../lib/vendor/php-github-api/lib/phpGithubApi.php';
    $this->dispatcher->connect('component.method_not_found', array('sfActionExtra', 'observeMethodNotFound'));
    
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
  }
}

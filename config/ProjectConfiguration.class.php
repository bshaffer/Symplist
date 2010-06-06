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
  }
}

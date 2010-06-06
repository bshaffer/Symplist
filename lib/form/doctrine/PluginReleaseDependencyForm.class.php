<?php

/**
 * PluginReleaseDependency form.
 *
 * @package    plugintracker
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PluginReleaseDependencyForm extends BasePluginReleaseDependencyForm
{
  public function configure()
  {
    sfApplicationConfiguration::getActive()->loadHelpers('Url');
    $this->widgetSchema['release_id'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['dependency_id'] = new sfWidgetFormJQueryAutocompleter(array('url' => url_for('@plugin_autocomplete')));
  }
}

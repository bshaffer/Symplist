<?php

/**
 * PluginAuthor form.
 *
 * @package    plugintracker
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id$
 */
class PluginAuthorForm extends BasePluginAuthorForm
{
  public function configure()
  {
    $this->widgetSchema['sf_guard_user_id'] = new sfWidgetFormInputHidden();
  }
}

<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Plugin configuration class
 *
 * @package    csDoctrineActAsAttachablePlugin
 * @subpackage configuration
 * @author     Gordon Franke <gfranke@nevalon.de>
 * @version    SVN: $Id: csDoctrineActAsAttachablePluginConfiguration.class.php 25142 2009-12-09 17:56:32Z gimler $
 */
class csDoctrineActAsAttachablePluginConfiguration extends sfPluginConfiguration
{
  /**
   * @see sfPluginConfiguration
   */
  public function initialize()
  {
    if (sfConfig::get('app_cs_doctrine_act_as_attachable_plugin_routes_register', true))
    {
      $this->dispatcher->connect(
        'routing.load_configuration',
        array(
          'csDoctrineActAsAttachableRouting',
          'listenToRoutingLoadConfigurationEvent'
        )
      );
    }
  }
}

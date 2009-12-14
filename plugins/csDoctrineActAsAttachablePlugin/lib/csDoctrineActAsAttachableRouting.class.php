<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Plugin routing class
 *
 * @package    csDoctrineActAsAttachablePlugin
 * @subpackage routing
 * @author     Gordon Franke <gfranke@nevalon.de>
 * @version    SVN: $Id: csDoctrineActAsAttachableRouting.class.php 25142 2009-12-09 17:56:32Z gimler $
 */
class csDoctrineActAsAttachableRouting
{
  /**
   * Listens to the routing.load_configuration event.
   *
   * @param sfEvent An sfEvent instance
   */
  static public function listenToRoutingLoadConfigurationEvent(sfEvent $event)
  {
    $r              = $event->getSubject();
    $enabledModules = sfConfig::get('sf_enabled_modules', array());

    // attachable
    if (in_array('csAttachable', $enabledModules))
    {
      $r->prependRoute(
        'cs_attachable_save',
        new sfRoute(
          '/cs/attachable/:table/:object_id',
          array('module' => 'csAttachable', 'action' => 'attachmentSave')
        )
      );
      $r->prependRoute(
        'cs_attachable_refresh',
        new sfRoute(
          '/cs/attachable/:table/:object_id/refresh',
          array('module' => 'csAttachable', 'action' => 'attachmentRefresh')
        )
      );
      $r->prependRoute(
        'cs_attachable_delete',
        new sfRoute(
          '/cs/attachable/:table/:object_id/:attachment_id/delete',
          array('module' => 'csAttachable', 'action' => 'attachmentDelete')
        )
      );
    }
  }
}

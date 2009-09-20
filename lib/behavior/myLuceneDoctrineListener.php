<?php
/*
 * This file is part of the sfLucenePlugin package
 * (c) 2007 Carl Vondrick <carlv@carlsoft.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Responsible for handling Doctrine's behaviors.
 * @package    sfLucenePlugin
 * @subpackage Behavior
 * @author     Carl Vondrick <carlv@carlsoft.net>
 * @author     Thomas Rabaix <thomas.rabaix@soleoweb.com>
 */
class myLuceneDoctrineListener extends sfLuceneDoctrineListener
{
   /**
   * Executes save routine
   */
  public function postSave(Doctrine_Event $event)
  {
    if ($event->getInvoker()->doIndex()) 
    {
      try {
        $this->saveIndex($event->getInvoker());
      } catch(sfException $e) {
        // no context define, cannot do anything, 
      }
    }
  }
}

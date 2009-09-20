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
 */
class myLuceneDoctrineTemplate extends sfLuceneDoctrineTemplate
{
  protected $_no_index = false;
  /**
   * setTableDefinition
   *
   * @return void
   */
  public function setTableDefinition()
  {
    $this->addListener(new myLuceneDoctrineListener);
  }
  
  public function saveNoIndex()
  {
    $this->_no_index = true;
    $this->getInvoker()->save();
  }
  
  public function doIndex()
  {
    return ($this->_no_index === false);
  }
}
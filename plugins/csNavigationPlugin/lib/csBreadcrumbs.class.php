<?php
/* 

 * The csBaseNavigation and csNavigationItem classes borrow heavily from the 
 * isicsBreadcrumbs class.  Both the isicsBreadcrumbs class and the csNavigation
 * plugin package cohere to the license below
 * 
 * 
 * csNavigationPlugin is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * csNavigationPlugin is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public License
 * along with isicsBreadcrumbsPlugin.  If not, see <http://www.gnu.org/licenses/>.
 */
class csBreadcrumbs
{
  static      $instance = null;
  protected   $appended_items = array();
  protected   $items    = array();
  
  /**
   * Breadcrumb Constructor
   *
   * mixed $items - 
   *      array            - generates breadcrumb from array values
   *      csNavigationMenu - generates breadcrumb from active state
   *      string           - fetches menu based on string name, generates breadcrumb
   *      
   *  else, adds default homepage breadcrumb
   *
   * @param string $items 
   * @author Brent Shaffer
   */
  public function __construct($items = null)
  {
    if (is_array($items)) 
    {
      foreach ($items as $item) 
      {
        $this->addItem($item);
      }
    }
    elseif ($items instanceof csNavigationMenu) 
    {
      $this->_items = $items->getBreadcrumbs();
    }
    elseif (is_string($items)) 
    {
      $menu = Doctrine::getTable('csNavigationMenu')->getMenu($items);
      $this->_items = $menu->getBreadcrumbs();
    }
    else
    {
      $this->addItem('Home', '@homepage');
    }
  }
  
  /**
   * Retrieve an array of csNavigationItems
   *
   * @param int $offset
   */
  public function getItems($offset = 0)
  {
    return array_slice($this->items, $offset);
  }
  
  /**
   * Add an item
   *
   * @param mixed $name
   * @param string $route
   */
  public function addItem($name, $route = null)
  {
    if($name instanceof csNavigationItem)
    {
      $item = $name;
    }
    else
    {
      $item = new csNavigationItem();
      $item->name = $name;
      $item->route = $route;
    }
    array_push($this->items, $item);
  }
  
  public function hasItems()
  {
    return (sizeof($this->getItems()) > 0) ;
  }
  
  public function numItems()
  {
    return sizeof($this->getItems());
  }
  
  /**
   * Redefine the root item
   *
   */
  public function setRoot($name, $route)
  {
    $root = new csNavigationItem();
    $root->name = $name;
    $root->route = $route;
    $this->items[0] = $root;
  }
  
  /**
   * Breadcrumb items to array
   *
   */
  public function toArray()
  {
    $arr = array();
    foreach ($this->getBreadcrumbs() as $item) 
    {
      $arr[] = $item->toArray();
    }
    return $arr;
  }
  
  // =======================
  // = Singleton Functions =
  // =======================
  
  public static function getInstance()
  {
    if (!self::hasInstance())
    {
      self::$instance = self::createInstance();
    }
    return self::$instance;
  }

  public static function hasInstance()
  {
    return !is_null(self::$instance);
  }

  public static function createInstance()
  {
    return new csBreadcrumbs();
  }
}
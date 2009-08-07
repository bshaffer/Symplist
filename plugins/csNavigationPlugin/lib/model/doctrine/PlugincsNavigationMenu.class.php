<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class PlugincsNavigationMenu extends BasecsNavigationMenu
{ 
  public function createRoot($root)
  {
    $this['NavigationRoot'] = $root;
    
    $root->save();
    
    $treeObject = Doctrine::getTable('csNavigationItem')->getTree();

    $treeObject->createRoot($root);
    
    $this->save();
    
    return $root;
  }

   /**
  * 
  *
  * @param string $root_level - The level of the root node for this segment
  *                            (lowest possible is zero)
  * @param string $iteration - number of levels displayed (0 displays all levels)
  * @return void
  * @author Brent Shaffer
  */
  public function getSegment($root_level, $iterations = null, $root = null)
  {
    $items = $root_level ? $this->getChildrenForRoot($root_level) : $this['NavigationRoot']->getChildren();

    $segment = $this->getSegmentItems($items, $root_level, $iterations);

    $root = clone $this['NavigationRoot'];  //Currently only supports one root
    $root->setChildren($segment);
    
    return $root;
  }

  public function getSegmentItems($items, $root_level = 0, $iterations = null)
  {
   $segment = new Doctrine_Collection('csNavigationItem');

   foreach ($items as $item) 
   {
     $children = $this->getSegmentItems($item->getChildren(), $root_level, $iterations);

     // If the level is beneath this one, return the children of this object
     if ($item->level <= $root_level) 
     {
       $segment->merge($children);
     }
     // if iterations are not set, or the item is within the iteration
     elseif(!$iterations || $item->getLevel() <= ($root_level + $iterations))
     {
       $new_segment = clone $item;
       $new_segment->setChildren($children);
       $segment[] = $new_segment;
     }
   }

   return $segment;
  }

  /**
  * determines what branch of the segment root 
  * to display
  *
  * @param string $level 
  * @return void
  * @author Brent Shaffer
  */
  public function getChildrenForRoot($level)
  {
   foreach($this['NavigationRoot']->getChildren() as $child)
   {
     if($active = $child->findActiveItemForLevel($level))
     {
       break;
     }
   }
   if ($active) 
   {
     return $active->getChildren();
   }
   return array();
  }
  
  public function findActiveItem()
  {
   foreach ($this['NavigationRoot']->getChildren() as $item) 
   {
     if ($ret = $item->findActiveItem()) 
     {
       return $ret;
     }
   }
   return null;
  }

  /**
  * For adding dynamic elements to a branch of a tree.
  * Use in the setup() method.
  *
  * @param string $parentName - Name of the navigation item to add to
  * @param string $item - mixed, either the string name of the new item, or the route object
  * @param string $route (optional) - the route if $item is the string name
  * @return void
  * @author Brent Shaffer
  */
  public function appendItem($parentName, $item, $route = null)
  {
   $parent = $this->matchItemByName($parentName);
   if(!$parent)
   {
     return false;
   }
   if(!$item instanceof csNavigationItem)
   {
     $item = new csNavigationItem($item, $route);
   }
   if(!$item->getLevel())
   {
     $item->level = ($parent->getLevel() + 1);
   }
   $parent->addChild($item);
   return $parent;
  }

  /**
   * matches a navigation item by its name
   * Useful when appending items to the navigation tree
   *
   * @param string $name 
   * @return void
   * @author Brent Shaffer
   */
  public function matchItemByName($name)
  {
    return $this['NavigationRoot']->matchItemByName($name);
  }

  /*
   TODO Refactor or Deprecate
  */
  public function getBreadcrumbs()
  {
    return $this['NavigationRoot']->getActivePath();
  }
}
<?php

class csNavigationHelper
{
  protected static $_settings = array();
  protected static $_navigation = array();
  
  /**
   * load
  * static method to pre-load the specified settings into memory. Use this
  * early in execution to avoid multiple SQL calls for individual settings.
  * Takes either a string or an array of strings as an argument.
   * 
   * @param mixed $settings 
   * @static
   * @access public
   * @return void
   */
  static function init($settings, $navigation, $rebuild = false)
  {
    // Implements Caching for navigation tree
    $cachePath = sfConfig::get('sf_cache_dir').'/navigation_tree.cache';
    if (!file_exists($cachePath))
    {
      // Populate the Navigation Tree
      if(isset($settings['database']['driven']) && $settings['database']['driven'])
      { 
        //Populate Tree from Database
        if($rebuild || !Doctrine::getTable('csNavigationItem')->isPopulated())
        {
          //Build Database from Existing navigation.yml file
          $tree = self::initDatabaseFromYaml($navigation, $rebuild);
        }
        else
        {
          //Pull from database, create navigation structure
          $tree = self::getNavigationTreeFromDatabase();          
        }
      }
      else
      {
        //Populate tree from navigation.yml
        $tree = self::getNavigationTreeFromYaml($navigation);
      }

      $menuTable = Doctrine::getTable('csNavigationMenu');
      
      $menuTable->storeTree($tree);
      
      // Run the configure() method for dynamically adding branches
      Doctrine::getTable('csNavigationMenu')->configure();
      
      $tree = $menuTable->restoreTree();

      // Cache Tree
      $serialized = serialize($tree->toArray());
      file_put_contents($cachePath, $serialized);
    } 
    else
    {
      Doctrine::getTable('csNavigationMenu')->storeTree(self::getTree());
    }
    self::$_settings = $settings;
  }
  
  /**
   * Pulls tree from cache directory (set by self::init())
   *
   * @return void
   * @author Brent Shaffer
   */
  static function getTree()
  {
    $cachePath = sfConfig::get('sf_cache_dir').'/navigation_tree.cache';
    if (!file_exists($cachePath))
    {
      throw new sfException('You must add the csNavigationFilter class to your routing.yml 
                              (see csNavigationPlugin\s README for more information)');
    }
    
    // Pull navigation tree from cache
    $unserialized = unserialize(file_get_contents($cachePath));

    $menus = new csNavigationCollectionManager();

    foreach ($unserialized as $menu_arr) 
    {
      $menu = new csNavigationMenu();
      $menu->fromArray($menu_arr);
      $menus[] = $menu;
    }

    return $menus;
  }
  
  static function initDatabaseFromYaml($navigation, $rebuild = false)
  {
    if ($rebuild) self::dropTables();
    return self::getNavigationTreeFromYaml($navigation, true);
  }
  
  static public function dropTables()
  {
    Doctrine::getTable('csNavigationMenu')->findAll()->delete();
    Doctrine::getTable('csNavigationItem')->findAll()->delete();
  }
  
  static function getNavigationTreeFromYaml($arr, $commit = false)
  {
    $menu_tree = new csNavigationCollectionManager();
    
    foreach ($arr as $key => $value) 
    {
      if (!is_array($value)) 
      {
        throw new sfException(sprintf('You have declared the navigation root "%s" without declaring any child attributes.', $key));
      }

      $cleaned = self::cleanItemAttributes($value);
      
      $menu = new csNavigationMenu();

      $menu->title = $key;

      $root = new csNavigationItem();

      $root->name = $key;
      
      $root->level = 0;
      
      $root->fromArray($cleaned['attributes']);

      if($commit)
      {
        $menu->createRoot($root);
      }
      
      $root = self::getNavigationBranchFromYaml($root, $cleaned['children'], $commit);

      $menu['NavigationRoot'] = $root;

      $menu_tree[] = $menu;
    }
    
    return $menu_tree;
  }
  
  /**
   * Create a navigation tree from the navigation.yml file
   *
   * @param string $arr 
   * @param string $level 
   * @param string $root 
   * @return void
   * @author Brent Shaffer
   */
  static function getNavigationBranchFromYaml($root, $arr, $commit = false, $level = 1)
  {
    $tree = new Doctrine_Collection('csNavigationItem');

    foreach ($arr as $key => $value) 
    {
      $root->refresh();
      
      if(is_array($value))
      {
        $cleaned = self::cleanItemAttributes($value);
        
        $item = new csNavigationItem();

        $item->name = $key;

        $item->level = $level;
        
        $item->fromArray($cleaned['attributes']);
        
        if ($commit) 
        {
          $item->save();
          $item->getNode()->insertAsLastChildOf($root);
        }
        
        if($cleaned['children'])
        {
          $item = self::getNavigationBranchFromYaml($item, $cleaned['children'], $commit, $level + 1);
        }
      }
      else
      {
        $item = new csNavigationItem();

        $item->name = $key;
        
        $item->route = $value;
        
        $item->level = $level;

        if ($commit) 
        {
          $root->getNode()->addChild($item);
        }
      }
      $root->addItem($item);
    }
    return $root;
  }
  
  
  static function getNavigationTreeFromDatabase()
  {
    $tree = new csNavigationCollectionManager();
    $menus = Doctrine::getTable('csNavigationMenu')->findAll();
    foreach ($menus as $menu) 
    {
      $menu['NavigationRoot'] = self::getNavigationTreeFromNestedSet($menu['NavigationRoot']);
      $tree[] = $menu;
    }
    return $tree;
  }
  /**
   * Converts nested set from Database into array form
   *
   * @param string $obj 
   * @return void
   * @author Brent Shaffer
   */
  static function getNavigationTreeFromNestedSet($obj = null)
  {
    if($children = $obj->getNode()->getChildren())
    {
      foreach ($children as $child_obj) {
        $child = self::getNavigationTreeFromNestedSet($child_obj);
        $obj->addChild($child);
      }
    }
    return $obj;
  }
  
  /**
   * Parses Navigation Item attributes in navigation.yml
   *
   * @param string $arr 
   * @return void
   * @author Brent Shaffer
   */
  static function cleanItemAttributes($arr)
  {
    $attr = array('attributes' => array(), 
                  'children' => array());
                  
    foreach ($arr as $key => $value) {
      if (strpos($key, '~') === 0) 
      {
        $attr['attributes'][substr($key, 1)] = $value;
      }
      else
      {
        $attr['children'][$key] = $value;
      }
    }
    return $attr;
  }
}
<?php
/* 
 * This file is part of the isicsBreadcrumbsPlugin package.
 * 
 * Copyright (C) 2007-2008 ISICS.fr <contact@isics.fr>
 * 
 * isicsBreadcrumbsPlugin is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * isicsBreadcrumbsPlugin is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public License
 * along with isicsBreadcrumbsPlugin.  If not, see <http://www.gnu.org/licenses/>.
 */

abstract class BasecsNavigationComponents extends sfComponents 
{
  public function executeBreadcrumbs()
  {
    // pulls the current csBreadcrumb instance if there is one
    // if one does not exist, attempts to generate one from the URL
    $this->items = csBreadcrumbs::hasInstance() ? 
                      csBreadcrumbs::getInstance()->getItems() :
                      Doctrine::getTable('csNavigationMenu')->getMenu()->getBreadcrumbs();
  }
  
  public function executeTree()
  {
    $this->iterations = $this->iterations or 0;
    $this->level = $this->level or 0;

    $this->max_level = $this->level + $this->iterations;
    
    if(!isset($this->items))
    {
      $nav = Doctrine::getTable('csNavigationMenu')->getMenu($this->menu);
      
      $root = $nav->getSegment($this->level, $this->iterations);
      
      $this->items = $root->getChildren();
    }
  }
}
<?php

/**
 * csNavicationFilter 
 * Filter for pre-execution loading of settings specified by the user in
 * config/defaults.yml
 * 
 * @uses sfFilter
 * @package 
 * @version $id$
 * @copyright 2006-2007 Chris Wage
 * @author Chris Wage <cwage@centresource.com> 
 * @license See LICENSE that came packaged with this software
 */
class csNavigationFilter extends sfFilter
{
  /**
   * execute 
   * 
   * @param mixed $filterChain 
   * @access public
   * @return void
   */
  public function execute($filterChain)
  {
   if ($this->isFirstCall())
   {
    if(file_exists(sfConfig::get('sf_config_dir').'/navigation.yml'))
    {
      $path = sfConfig::get('sf_config_dir').'/navigation.yml';
    }
    else
    {
      $path = sfConfig::get('sf_app_config_dir').'/navigation.yml';
    }
    include(sfContext::getInstance()->getConfigCache()->checkConfig($path));
    csNavigationHelper::init($settings, $navigation);
   }
   $filterChain->execute();
  }
}

?>

<?php

/**
 * sfSettingsFilter 
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
class sfSettingsFilter extends sfFilter
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
		include(sfContext::getInstance()->getConfigCache()->checkConfig(sfConfig::get('sf_app_config_dir').'/defaults.yml'));
		if(isset($default_settings))
		{
			sfSettings::load($default_settings);	
		}
	 }
	 $filterChain->execute();
  }
}

?>

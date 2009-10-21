<?php

/**
 * BasesfSettings 
 * 
 * @package 
 * @version $id$
 * @copyright 2006-2007 Chris Wage
 * @author Chris Wage <cwage@centresource.com> 
 * @license See LICENSE that came packaged with this software
 */
class BasesfSettings
{
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
  static function load($settings)
  {
	 if (is_string($settings)) {
		$settings = array($settings);
	 } elseif (!is_array($settings)) {
		// Not a string or array, bomb out:
		return 0;
	}
	$query = new Doctrine_Query();
	$query->addSelect("s.*");
	$query->addFrom("sfSetting s");
	$where = array();
	foreach ($settings as $setting) {
	  $where[] = "name = '$setting'";
	}
	$where = implode($where, " OR ");
	$query->addWhere($where);
	$result = $query->execute();
        $objArray = array();
	foreach ($result as $setting)
	{
	  $objArray[$setting->getName()] = $setting;
	}
	sfContext::getInstance()->getRequest()->setAttribute('sfSettings', $objArray);
  }

  /**
   * getSetting
	* pulls the sfSetting object for a given setting
   * 
   * @param string $setting 
   * @static
   * @access public
   * @return object sfSetting
   */
  static function getSetting($setting)
  {
	 if (!is_string($setting) || empty($setting)) {
		return 0;
	}
	// If all the settings have been requested, there's no need to check for
	// individuals. This avoids additional queries later on.
	if (sfContext::getInstance()->getRequest()->hasAttribute('AllsfSettings')) {
	 $settings = sfContext::getInstance()->getRequest()->getAttribute('AllsfSettings');
  } else {
	 $settings = sfContext::getInstance()->getRequest()->getAttribute('sfSettings');
	}
	 if (isset($settings[$setting])) {
		$obj = $settings[$setting];
		return $obj;
	 } else {
		// Setting was not pre-loaded via ->load() but we'll be nice and retrieve
		// the setting anyhow:
		$query = new Doctrine_Query();
		$query->addSelect("s.*");
		$query->addFrom("sfSetting s");
		$query->addWhere("s.name = :name", array(":name" => $setting));
		if ($obj = $query->limit(1)->execute()->getFirst()) {
		  // Store this setting in memory for later retrieval to avoid a second
		  // query for the same setting:
		  $settings[$obj->getName()] = $obj;
		  sfContext::getInstance()->getRequest()->setAttribute('sfSettings',
		  $settings);
		  // return it:
		  return $obj;
		} else {
		  return 0;
		}
	 }
  }

  /**
   * get 
	* Returns the string value of a particular setting.
   * 
   * @param string $setting 
   * @static
   * @access public
   * @return string
   */
  static function get($setting)
  {
	 if ($obj = self::getSetting($setting)) {
		return $obj->getValue();
	 } else {
		return 0;
	 }
  }

  /**
   * getAllSettings 
   * Returns an array of all setting objects 
   * @static
   * @access public
   * @return array
   */
  static function getAllSettings()
  {
	 if (sfContext::getInstance()->getRequest()->hasAttribute('AllsfSettings')) {
		return
		sfContext::getInstance()->getRequest()->getAttribute('AllsfSettings');
	 } else {
		$query = new Doctrine_Query();
		$query->addFrom("sfSetting s");
		$result = $query->execute()->getData();
		$objArray = array();
		foreach ($result as $setting)
		{
		  $objArray[$setting->getName()] = $setting;
		}
		sfContext::getInstance()->getRequest()->setAttribute('AllsfSettings',
		$objArray);
		return $objArray;
	 }
  }

  /**
   * getAll 
	* Returns a hash of settings
   * 
   * @static
   * @access public
   * @return void
   */
  static function getAll()
  {
	 $result = array();
	 foreach (self::getAllSettings() as $obj)
	 {
	 	$result[$obj->getName()] = $obj->getValue();
	 }
	 return $result;
  }
}

?>

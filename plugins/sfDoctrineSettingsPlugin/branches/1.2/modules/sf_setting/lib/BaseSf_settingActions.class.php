<?php

/**
 * BasesfSettingsActions 
 * 
 * @uses autosfSettingsActions
 * @package 
 * @version $id$
 * @copyright 2006-2007 Chris Wage
 * @author Chris M. Wage <cwage@centresource.com>
 * @license See LICENSE that came packaged with this software
 */
class BaseSf_settingActions extends AutoSf_settingActions
{
	  public function executeValue_element()
  {
    $setting_id = $this->getRequestParameter('setting_id');

    $this->sf_setting = Doctrine::getTable('sfSetting')->find($setting_id);
    $this->sf_setting = $this->sf_setting ? $this->sf_setting:new sfSetting();

    if( $this->getRequest()->hasParameter('type') )
    {
      $this->sf_setting->setType($this->getRequestParameter('type'));
    }

    if( $this->getRequest()->hasParameter('options') )
    {
      $this->sf_setting->setOptions($this->getRequestParameter('options'));
    }
  }

  public function executeListSaveSettings(sfWebRequest $request)
  {
    if($settings = $this->getRequestParameter('settings'))
		{
			foreach($settings AS $setting_id => $value)
	    {
	      $setting = Doctrine::getTable('sfSetting')->find($setting_id);
	      $setting->setValue($value);

	      $setting->save();
	    }
		}
		
		if($files = $request->getFiles('settings'))
		{
			$this->processUpload($files);
		}
    $this->getUser()->setFlash('notice', 'Your settings have been saved.');
    $this->redirect('@sf_setting');
  }
	public function processUpload($files)
	{

		$target_path = "uploads/setting/";
		if(!file_exists("uploads/setting"))
		{
			$target_path = mkdir('uploads/setting') ? $target_path : 'uploads/';
		}
		foreach ($files as $setting_id => $file) 
		{
			if ($file['name']) 
			{
			  $setting = Doctrine::getTable('sfSetting')->find($setting_id);
				$target_path = $target_path . basename( $file['name']); 
			
				if(!move_uploaded_file($file['tmp_name'], $target_path)) 
				{
					$this->getUser()->setFlash('error', 'There was a problem uploading your file!');
				}
				else
				{
					$setting->setValue($name);
					$setting->save();
				}
			}
		}
	}
}

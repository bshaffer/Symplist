<?php

/**
* releaseActions
*/
class releaseActions extends sfActions
{
  public function executeNew(sfWebRequest $request)
  {
    $this->plugin = $this->getRoute()->getObject();
    
    $this->form = new PluginReleaseForm(null, array('plugin' => $this->plugin));

    $this->packageForm = new PluginReleasePackageForm();
    
    if ($request->isMethod('POST')) 
    {
      $this->packageForm->bind($request->getParameter('package'), $request->getFiles('package'));
      
      if ($this->packageForm->isValid()) 
      {
        $this->form->bind($request->getParameter('plugin_release'));
    
        if ($this->form->isValid()) 
        {
          $release = $this->form->save();
      
          $this->doCreate($release);
        }
      }
    }
  }
  
  protected function doCreate($release)
  {
    $plugin = $release['Plugin'];
    
    // Create Git Repository
  }
  
  public function executeDependency(sfWebRequest $request)
  {
    $form = new PluginReleaseDependencyForm();
    
    return $this->renderText((string)$form);
  }
}

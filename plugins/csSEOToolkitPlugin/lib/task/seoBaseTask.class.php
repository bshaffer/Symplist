<?php

abstract class seoBaseTask extends sfBaseTask
{
	public function logMessage($message, $em = false)
	{
		$emStyle = array('bg' => 'black', 'fg' => 'yellow', 'bold' => true);
		$message = $em ? sprintf($message, $this->formatter->format($em, $emStyle)) : $message;
		$this->logSection('seo', $message);
	}
	public function removePages($pages, $options)
	{
		if(
			!(isset($options['no-confirmation']) && $options['no-confirmation']) && 
			!$this->askConfirmation(array('This command will remove '.count($pages).' page(s) from your database.', 'Are you sure you want to proceed? (y/N)'), null, false)
    )
    {
      $this->logSection('seo', 'task aborted');
      return 1;
    }
		foreach ($pages as $page) 
		{
			$page->delete();
		}
		$this->logSection('seo', count($pages).' pages deleted successfully');
	}
}
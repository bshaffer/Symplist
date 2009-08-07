<?php

/**
* 
*/
class SeoLimeTest extends lime_test
{
	protected $_comments;
	
	function __construct($comments = false)
	{
		parent::__construct();
		$this->_comments = $comments;
	}
	
	function __destruct()
	{
		if($this->_comments)
		{
			parent::__destruct();
		}
	}
}

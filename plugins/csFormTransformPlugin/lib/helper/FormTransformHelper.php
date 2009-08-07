<?php
use_helper('Javascript');
fancy_assets();
function fancy_assets()
{
	
	foreach (sfConfig::get('app_csFormTransformPlugin_javascripts') as $javascript) 
	{
		sfContext::getInstance()->getResponse()->addJavascript($javascript, 'last');
	}
	foreach (sfConfig::get('app_csFormTransformPlugin_stylesheets') as $stylesheet) 
	{
		sfContext::getInstance()->getResponse()->addStylesheet($stylesheet, 'last');
	}
	echo javascript_tag('$(function() { $("form.jqtransform").jqTransform();});');
}
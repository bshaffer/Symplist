<?php

/**
 * SeoInflector
 * Provides helpful functions for pulling summaries out of blocks of text
 *
 * @package default
 * @author Brent Shaffer
 */
class SeoInflector
{
	public static $_split_tags = array('</p>', '<br>', '<br />', '</blockquote>', '</div>');
	public static $_maxlen  = 255;
	
	
	static function summarize($text, $limit = null)
	{
		$text = SeoPurifier::purify($text);	
		$summary = '';
		foreach (self::$_split_tags as $tag) 
		{
			if($i = strpos($text, $tag))
			{
				$summary = substr($text, 0, $i);
				break;
			}
		}
		$length = ($limit && $limit < self::$_maxlen) ? $limit : self::$_maxlen; 
		$summary = ($summary && $limit) ? self::truncate(strip_tags($summary), $limit) : ($text ? self::truncate(strip_tags($text), $length) : ''); 
		return $summary;
	}
	static function truncate($text, $length, $ellipses = true)
	{
		if (strlen($text) > $length) 
		{
			$trunc = trim(substr($text, 0, $length));
			return $ellipses ? $trunc.'...' : $trunc;
		}
		return $text;
	}
}

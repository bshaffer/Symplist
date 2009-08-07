<?php
// require_once dirname(__FILE__).'/../vendor/simplehtmldom/simple_html_dom.php';

/**
 * SeoKeywordToolkit
 * Helper class for encoding / decorating content keywords
 *
 * @package default
 * @author Brent Shaffer
 */
class SeoKeywordToolkit
{
 	private static $instance;

  protected function __construct()
  {

  }
  
  public static function getInstance() 
  {
    if (!self::$instance instanceof self) 
		{ 
      self::$instance = new self;
    }
    
    return self::$instance;
  }
	
	public function encode($text, $words)
	{
		$salt = rand();
		$matches = array();
		
		foreach ($words as $i => $word) 
		{
			preg_match_all("/$word/i", $text, $matches[$word]);

			foreach ($matches[$word][0] as $j => $match) 
			{
				$text = str_replace($match, "%%$j-$salt-$i%%", $text);
			}
		}

		foreach ($words as $i => $word) 
		{
			foreach ($matches[$word][0] as $j => $match) 
			{
				$text = str_replace("%%$j-$salt-$i%%", $this->decorate($match), $text);
			}
		  
		}
		return $text;
	}

	public function parseBlock($source, $selector = null)
	{
		$words = $this->getDefaultKeywords();
		if($selector)
		{
			$dom = new simple_html_dom();
			$dom->load('<html><body>'.$source.'</body></html>');
			$blocks = $dom->find($selector); //"div[id=$class]"; 
			foreach ($blocks as $block) 
			{
				$new_block = $this->encode($block, $words);
				$source = str_replace($block, $new_block, $source);
			}
			return $source;
		}
		return $this->encode($source, $words);
	}
	
	
	public function decorate($hyperword)
	{
		return sprintf($this->getDecorator(), $hyperword, $hyperword);
	}
	public function getDecorator()
	{
		$decorator = '<em class="keyword">%s</em>';
		return $decorator;
	}
	public function getDefaultKeywords()
	{
		return Doctrine::getTable('Keyword')->findAllAsArray();
	}
}
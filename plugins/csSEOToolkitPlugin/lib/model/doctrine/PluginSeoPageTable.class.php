<?php

class PluginSeoPageTable extends Doctrine_Table
{
	/**
	 * getSearchQuery
	 * Performs a rudimentary search of metadata for specified keywords
	 * 
	 * @param string $keywords - array of keywords to search
	 * @return query to return search words
	 * @author Brent Shaffer
	 */
	public function getSearchQuery($keywords)
	{
		$q = $this->createQuery('p');
		foreach ($keywords as $keyword) 
		{
		   $q->orWhere('p.title like ?', "%$keyword%")
				 ->orWhere('p.description like ?', "%$keyword%")
				 ->orWhere('p.keywords like ?', "%$keyword%");
		}
		return $q;
	}
}
<?php


class PluginKeywordTable extends Doctrine_Table
{
	/**
	 * By default, collection is ordered by length descending.  This prevents word overlap
	 * ex: 'my word' will match before 'word'.  More "specific" Keywords match first
	 *
	 * @author Brent Shaffer
	 */
	public function createQuery($alias = '')
	{
		$q = parent::createQuery($alias);
		$q->select('*, LENGTH(name) as length')->orderBy('length DESC');
		return $q;
	}
	/**
	 * returns array of all keywords
	 *
	 * @return void
	 * @author Brent Shaffer
	 */
	public function findAllAsArray()
	{
		return $this->collectionToArray($this->findAll());
	}
	/**
	 * Instance of Doctrine_Collection to array
	 *
	 * @param string $collection - instance of Doctrine_Collection
	 * @return array
	 * @author Brent Shaffer
	 */
	public function collectionToArray($collection)
	{
		$arr = array();
		foreach ($collection as $keyword) 
		{
			$arr[] = $keyword->getName();
		}
		return $arr;
	}
}
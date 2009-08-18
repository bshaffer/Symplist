<?php

/**
* plugin Components class
*/
class pluginComponents extends sfComponents
{
  public function executeRating(sfWebRequest $request)
  {
    $this->star = round($this->rating, 0);
    $this->class = ($this->rating > $this->star ? 'selected-half' : 'selected');
  }
  
  public function executeHighest_ranking(sfWebRequest $request)
  {
    $this->plugins = Doctrine::getTable('SymfonyPlugin')->getHighestRanking($this->limit);
  }
  
  public function executeRecently_added(sfWebRequest $request)
  {
    $this->plugins = Doctrine::getTable('SymfonyPlugin')
                                  ->createQuery('p')
                                  ->orderBy('p.created_at DESC')
                                  ->limit($this->limit)
                                  ->execute();
  }
  
  public function executeMost_votes(sfWebRequest $request)
  {
    $this->plugins = Doctrine::getTable('SymfonyPlugin')->getMostVotes($this->limit);
  }
}

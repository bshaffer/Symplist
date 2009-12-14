<?php

/**
* 
*/
class siteComponents extends sfComponents
{
  public function executeSidebarDefault(sfWebRequest $request)
  {
    $this->highest = Doctrine::getTable('SymfonyPlugin')->getHighestRanking(3);
    $this->recent = Doctrine::getTable('SymfonyPlugin')
                                  ->createQuery('p')
                                  ->orderBy('p.created_at DESC')
                                  ->limit(3)
                                  ->execute();
                                  
    $this->votes = Doctrine::getTable('SymfonyPlugin')->getMostVotes(3);
  }
}

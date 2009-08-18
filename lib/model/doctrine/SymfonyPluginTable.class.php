<?php
/**
 */
class SymfonyPluginTable extends Doctrine_Table
{  
  public function getHighestRanking($limit = null)
  {
    $q = $this->createQuery('p')
              ->select('p.*, AVG(c.rating) as average')
              ->leftJoin('p.SymfonyPluginComment pc')
              ->leftJoin('pc.Comment c')
              ->groupBy('p.id')
              ->having('average > 0')
              ->orderBy('average DESC');

   if ($limit) 
   {
     $q->limit($limit);
   }

   return $q->execute();
  }
  
  public function getMostVotes($limit = null)
  {
    $q = $this->createQuery('p')
              ->select('p.*, COUNT(c.rating) as num_votes')
              ->leftJoin('p.SymfonyPluginComment pc')
              ->leftJoin('pc.Comment c')
              ->groupBy('p.id')
              ->having('num_votes > 0')
              ->orderBy('num_votes DESC');

   if ($limit) 
   {
     $q->limit($limit);
   }

   return $q->execute();
  }
}
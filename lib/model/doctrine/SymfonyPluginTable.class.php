<?php
/**
 */
class SymfonyPluginTable extends Doctrine_Table
{  
  public function getHighestRanking($limit = null, $floor = null)
  {
    $q = $this->createQuery('p')
              ->select('p.*, AVG(r.rating) as average')
              ->leftJoin('p.PluginRating r')
              ->groupBy('p.id')
              ->having('average > 0')
              ->orderBy('average DESC');

   if ($limit) 
   {
     $q->limit($limit);
   }
   
   if ($floor) 
   {
     $q->having('average >= ?', $floor);
   }

   return $q->execute();
  }
  
  public function getMostVotes($limit = null)
  {
    $q = $this->createQuery('p')
              ->select('p.*, COUNT(r.rating) as num_votes')
              ->leftJoin('p.PluginRating r')
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
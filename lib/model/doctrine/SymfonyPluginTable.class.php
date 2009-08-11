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
              ->orderBy('average DESC');

   if ($limit) 
   {
     $q->limit($limit);
   }

   return $q->execute();
  }
}
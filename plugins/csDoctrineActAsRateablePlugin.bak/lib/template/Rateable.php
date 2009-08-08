<?php

// 
//  Sortable.php
//  csDoctrineActAsSortablePlugin
//  
//  Created by Travis Black on 2008-12-22.
//  Copyright 2008 Centre{source}. All rights reserved.
// 

class Doctrine_Template_Rateable extends Doctrine_Template
{    
  /**
   * Array of sortable options
   */  
  protected $_options = array(  'type'  =>  'stars' );


  /**
   * Constructor for Sortable Template
   *
   * @param array $options 
   * @return void
   * @author Travis Black
   */
  public function __construct(array $options = array())
  {
    $this->_options = Doctrine_Lib::arrayDeepMerge($this->_options, $options);
  }


  public function setup()
  {
  }


  /**
   * Setting up the ratings table
   * 
   *
   * @return void
   * @author Travis Black
   */
  public function setTableDefinition()
  { 
    $this->addListener(new Doctrine_Template_Listener_Rateable($this->_options));
  }

  /**
   * Demotes a sortable object to a lower position
   *
   * @return void
   * @author Travis Black
   */
   
   /**
   * parameterHolder access methods
   */
   public static function getRatingHolder($object)
   {
    if ((!isset($object->_rating)) || ($object->_rating == null))
    {
      $parameter_holder = 'sfNamespacedParameterHolder';
      $object->mapValue('_rating', new $parameter_holder());
    }

    return $object->_rating;
   }
   
   public static function get_rating($object)
   {
       return self::getRatingHolder($object)->getAll('rating');
   }
   
   public function getAverageRating()
   {
     $object = $this->getInvoker();
     
     $q = Doctrine_Query::create()
                        ->select('avg(rank) as average')
                        ->from('Rank rk')
                        ->where('class = ?', get_class($object))
                        ->addWhere('object_id = ?', $object['id'])
                        ->limit(1);
                        
     $topRatings = $q->execute();
     
     return $topRatings;
   }
   
   public function rate($rating){
     $object = $this->getInvoker();
     
     self::getRatingHolder($object)->set($rating, $rating, 'rating');
   }
   
   public function topTableProxy($limiter)
   {
     $object = $this->getInvoker();
     
     $q = Doctrine_Query::create()
                        ->select('*, avg(rank) as average')
                        ->from('Rank rk')
                        ->where('class = ?', get_class($object))
                        ->groupBy('object_id')
                        ->orderBy('average desc')
                        ->limit($limiter);
     
     $topRatings = $q->execute();
   }
   
   //worst rated objects - maybe handy for an admin to see what's downvoted
   public function bottomTableProxy($limiter)
   {
     $object = $this->getInvoker();
     
     $q = Doctrine_Query::create()
                        ->select('*, avg(rank) as average')
                        ->from('Rank rk')
                        ->where('class = ?', get_class($object))
                        ->groupBy('object_id')
                        ->orderBy('average asc')
                        ->limit($limiter);
     
     $bottomRatings = $q->execute();
   }
   
   //Get the lastest voted on Items....
   public function latestTableProxy($limiter)
   {
     $object = $this->getInvoker();
     
     $q = Doctrine_Query::create()
                        ->select('*, avg(rank) as average')
                        ->from('Rank rk')
                        ->where('class = ?', get_class($object))
                        ->groupBy('object_id')
                        ->orderBy('updated_at desc')
                        ->limit($limiter);
     
     $latestRatings = $q->execute();
   }
   
   //Get the number of votes with the average rank for an item
   public function voteCountTableProxy($limiter)
   {
     $object = $this->getInvoker();
     
     $q = Doctrine_Query::create()
                        ->select('count(*) as total, avg(rank) as average')
                        ->from('Rank rk')
                        ->where('class = ?', get_class($object))
                        ->where('id = ?', $object['id'])    
     $totalVotes = $q->execute();
   }
   
   //Get the most voted on items and their rank....
   public function latestTableProxy($limiter)
   {
     $object = $this->getInvoker();
     
     $q = Doctrine_Query::create()
                        ->select('*, count(*) as count, avg(rank) as average')
                        ->from('Rank rk')
                        ->where('class = ?', get_class($object))
                        ->groupBy('object_id')
                        ->orderBy('count desc')
                        ->orderBy('average desc')
                        ->limit($limiter);
     
     $latestRatings = $q->execute();
   }
   
}

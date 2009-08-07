<?php



class Doctrine_Template_Commentable extends Doctrine_Template
{
  /**
   * Array of Commentable options
   */  
  protected $_options = array(
                          'Commenter' => array(
                              'enabled'       =>   true,
                              'model'         =>  'Commenter',
                              'table_method'  =>  'addCommenter',
                              )
  );

  public function __construct(array $options = array())
  {
    $this->_options = Doctrine_Lib::arrayDeepMerge($this->_options, $options);    
    $this->_plugin = new Doctrine_Commentable($options);
  }

  public function getCommentUserFormClass()
  {
    return 'CommenterForm';
  }
  
  public function getCommentFormClass()
  {
    return 'CommentForm';
  }
  
  public function addComment($comment, $parent_id = null)
  {
    $object = $this->getInvoker();

    if(!$object['id'])
    {
      $object->save();
    }
    
    // if comment is nested, add it as a child of the parent comment
    if ($parent_id) 
    {
      $parent = Doctrine::getTable('Comment')->find($parent_id);
      if (!$parent->getNode()->isValidNode()) 
      {
        Doctrine::getTable('Comment')->getTree()->createRoot($parent);
      }
      $parent->getNode()->addChild($comment);
    }
    
    $object['Comments'][] = $comment;
  }
  
  public function getCommentThread()
  {
    $object = $this->getInvoker();
    $comments = new Doctrine_Collection('Comment');
    foreach ($object['Comments'] as $comment) 
    {
      if ($comment['level'] == 0) 
      {
        $comments[] = $comment;
      }
    }
    return $comments;
  }

  public function addCommentFromArray($commentArr)
  {
    foreach ($commentArr as $key => $value) {
      $comment = new Comment();
      $comment->$key = $value;
      $this->addComment($comment);
    }
  }

  public function getNumComments()
  {
    $object = $this->getInvoker();
    $count = 0;
    foreach ($object['Comments'] as $comment) 
    {
      if ($comment->isApproved()) 
      {
        $count++;
      }
    }
    return $count;
  }

  public function setUp()
  {
    $this->_plugin->initialize($this->_table);
    
    // $dispatcher = ProjectConfiguration::getActive()->getEventDispatcher();
    // $event = new sfEvent($this, 'plugin.add_settings');    
    // $dispatcher->notify($event);
  }
}
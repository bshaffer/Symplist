<?php 

class Doctrine_Commentable extends Doctrine_Record_Generator
{
  protected $_options = array('commentClass'      => 'Comment',
                              'commentAlias'      => 'Comments',
                              'className'         => '%CLASS%Comment',
                              'local'             => 'id',
                              'generateFiles'     => false,
                              'table'             => false,
                              'pluginTable'       => false,
                              'children'          => array(),
                              'builderOptions'    => array('BaseClassesDirectory' => 'base'));
                            
  protected $_commentables = array();

  /**
   * __construct
   *
   * @param string $options 
   * @return void
   */
  public function __construct(array $options = array())
  {
    $dispatcher = ProjectConfiguration::getActive()->getEventDispatcher();
    $dispatcher->connect('commentable.add_commentable_class', array($this, 'getCommentables'));
  
    $options['generatePath'] = sfConfig::get('sf_lib_dir').'/model/doctrine/sfCommentsPlugin';
    $this->_options = Doctrine_Lib::arrayDeepMerge($this->_options, $options);
  }

  public function setTableDefinition()
  {
    $this->hasColumn('comment_id', 'integer', null, array('primary' => true));
  }

  public function buildRelation()
  {
    $this->addCommentable($this->getOption('table')->getComponentName());
  
    // Set index on Comment Table
    $options = array('local'    => 'comment_id',
                     'foreign'  => 'id',
                     'onDelete' => 'CASCADE',
                     'onUpdate' => 'CASCADE');
  
    $this->_table->bind(array($this->_options['commentClass'], $options), Doctrine_Relation::ONE);

    //Set index on Commentable Object Table
    $options = array('local'    => 'id',
                     'foreign'  => 'comment_id',
                     'refClass' => $this->getOption('table')->getComponentName() . $this->_options['commentClass']);
  
    $this->getOption('table')->bind(array($this->_options['commentClass'] . ' as ' . $this->_options['commentAlias'], $options), Doctrine_Relation::ONE);

    parent::buildRelation();
  }

  public function getCommentables(sfEvent $event)
  {
    $event->setReturnValue($this->_commentables);
  }

  public function addCommentable($class)
  {
    $this->_commentables[] = $class;
  }
}
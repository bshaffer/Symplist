<?php

/**
 * SymfonyPlugin filter form.
 *
 * @package    plugintracker
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id$
 */
class SymfonyPluginFormFilter extends BaseSymfonyPluginFormFilter
{
  public function configure()
  {
    $this->useFields(array('title', 'description', 'featured', 'symplist_index'));
    
    $this->widgetSchema['symplist_index'] = new sfWidgetFormInputCheckbox();
    $this->validatorSchema['symplist_index'] = new sfValidatorBoolean(array('required' => false));
    $this->widgetSchema->setLabel('symplist_index', 'Has Symplist Index');
  }
  
  public function addSymplistIndexColumnQuery(Doctrine_Query $query, $field, $value)
  {
    if ($value) 
    {
      $query->andWhere('symplist_index IS NOT NULL');
    }
    
    return $query;
  }
}

<?php

/**
 * PluginModelAttachment form.
 *
 * @package    form
 * @subpackage ModelAttachment
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
abstract class PluginModelAttachmentForm extends AttachmentForm
{
  public function setUp()
  {
    $this->getObject()->setType('model');
    parent::setUp();
    $config = $this->getRelatedObject()->getAttachableConfig('attachableModels');
  
    //Currently only allows for a single model
    $choices = $this->getArrayFromCollection(Doctrine_Core::getTable($config[0])->findAll());
  
    $this->widgetSchema['url'] = new sfWidgetFormChoice(array('choices' => $choices));
    $this->validatorSchema['url'] = new sfValidatorString();
  }
  public function getArrayFromCollection($collection, $choices = array())
  {
    foreach ($collection as $record) 
    {
      $choices[$record->getRoute()] = $record->__toString();
    }
    return $choices;
  }
}
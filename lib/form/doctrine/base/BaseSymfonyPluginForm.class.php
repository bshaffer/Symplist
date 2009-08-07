<?php

/**
 * SymfonyPlugin form base class.
 *
 * @package    form
 * @subpackage symfony_plugin
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseSymfonyPluginForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'title'       => new sfWidgetFormInput(),
      'description' => new sfWidgetFormTextarea(),
      'author_id'   => new sfWidgetFormDoctrineChoice(array('model' => 'PluginAuthor', 'add_empty' => true)),
      'category_id' => new sfWidgetFormDoctrineChoice(array('model' => 'PluginCategory', 'add_empty' => true)),
      'active'      => new sfWidgetFormInputCheckbox(),
      'slug'        => new sfWidgetFormInput(),
      'created_at'  => new sfWidgetFormDateTime(),
      'updated_at'  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorDoctrineChoice(array('model' => 'SymfonyPlugin', 'column' => 'id', 'required' => false)),
      'title'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'description' => new sfValidatorString(array('required' => false)),
      'author_id'   => new sfValidatorDoctrineChoice(array('model' => 'PluginAuthor', 'required' => false)),
      'category_id' => new sfValidatorDoctrineChoice(array('model' => 'PluginCategory', 'required' => false)),
      'active'      => new sfValidatorBoolean(array('required' => false)),
      'slug'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'  => new sfValidatorDateTime(array('required' => false)),
      'updated_at'  => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('symfony_plugin[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SymfonyPlugin';
  }

}

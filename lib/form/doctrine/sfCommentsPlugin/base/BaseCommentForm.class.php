<?php

/**
 * Comment form base class.
 *
 * @package    form
 * @subpackage comment
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseCommentForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'body'                => new sfWidgetFormTextarea(),
      'approved'            => new sfWidgetFormInputCheckbox(),
      'approved_at'         => new sfWidgetFormDateTime(),
      'user_id'             => new sfWidgetFormDoctrineChoice(array('model' => 'Commenter', 'add_empty' => true)),
      'root_id'             => new sfWidgetFormInput(),
      'lft'                 => new sfWidgetFormInput(),
      'rgt'                 => new sfWidgetFormInput(),
      'level'               => new sfWidgetFormInput(),
      'created_at'          => new sfWidgetFormDateTime(),
      'updated_at'          => new sfWidgetFormDateTime(),
      'symfony_plugin_list' => new sfWidgetFormDoctrineChoiceMany(array('model' => 'SymfonyPlugin')),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorDoctrineChoice(array('model' => 'Comment', 'column' => 'id', 'required' => false)),
      'body'                => new sfValidatorString(array('required' => false)),
      'approved'            => new sfValidatorBoolean(array('required' => false)),
      'approved_at'         => new sfValidatorDateTime(array('required' => false)),
      'user_id'             => new sfValidatorDoctrineChoice(array('model' => 'Commenter', 'required' => false)),
      'root_id'             => new sfValidatorInteger(array('required' => false)),
      'lft'                 => new sfValidatorInteger(array('required' => false)),
      'rgt'                 => new sfValidatorInteger(array('required' => false)),
      'level'               => new sfValidatorInteger(array('required' => false)),
      'created_at'          => new sfValidatorDateTime(array('required' => false)),
      'updated_at'          => new sfValidatorDateTime(array('required' => false)),
      'symfony_plugin_list' => new sfValidatorDoctrineChoiceMany(array('model' => 'SymfonyPlugin', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('comment[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Comment';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['symfony_plugin_list']))
    {
      $this->setDefault('symfony_plugin_list', $this->object->SymfonyPlugin->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveSymfonyPluginList($con);
  }

  public function saveSymfonyPluginList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['symfony_plugin_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (is_null($con))
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->SymfonyPlugin->getPrimaryKeys();
    $values = $this->getValue('symfony_plugin_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('SymfonyPlugin', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('SymfonyPlugin', array_values($link));
    }
  }

}

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
      'id'                => new sfWidgetFormInputHidden(),
      'title'             => new sfWidgetFormInput(),
      'description'       => new sfWidgetFormTextarea(),
      'user_id'           => new sfWidgetFormDoctrineChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'symfony_developer' => new sfWidgetFormInput(),
      'category_id'       => new sfWidgetFormDoctrineChoice(array('model' => 'PluginCategory', 'add_empty' => true)),
      'active'            => new sfWidgetFormInputCheckbox(),
      'repository'        => new sfWidgetFormInput(),
      'image'             => new sfWidgetFormInput(),
      'homepage'          => new sfWidgetFormInput(),
      'ticketing'         => new sfWidgetFormInput(),
      'slug'              => new sfWidgetFormInput(),
      'created_at'        => new sfWidgetFormDateTime(),
      'updated_at'        => new sfWidgetFormDateTime(),
      'raters_list'       => new sfWidgetFormDoctrineChoiceMany(array('model' => 'sfGuardUser')),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorDoctrineChoice(array('model' => 'SymfonyPlugin', 'column' => 'id', 'required' => false)),
      'title'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'description'       => new sfValidatorString(array('required' => false)),
      'user_id'           => new sfValidatorDoctrineChoice(array('model' => 'sfGuardUser', 'required' => false)),
      'symfony_developer' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'category_id'       => new sfValidatorDoctrineChoice(array('model' => 'PluginCategory', 'required' => false)),
      'active'            => new sfValidatorBoolean(array('required' => false)),
      'repository'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'image'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'homepage'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'ticketing'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'slug'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'        => new sfValidatorDateTime(array('required' => false)),
      'updated_at'        => new sfValidatorDateTime(array('required' => false)),
      'raters_list'       => new sfValidatorDoctrineChoiceMany(array('model' => 'sfGuardUser', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'SymfonyPlugin', 'column' => array('title')))
    );

    $this->widgetSchema->setNameFormat('symfony_plugin[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SymfonyPlugin';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['raters_list']))
    {
      $this->setDefault('raters_list', $this->object->Raters->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveRatersList($con);
  }

  public function saveRatersList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['raters_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (is_null($con))
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Raters->getPrimaryKeys();
    $values = $this->getValue('raters_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Raters', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Raters', array_values($link));
    }
  }

}

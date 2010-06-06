<?php

/**
 * SymfonyApiVersion form base class.
 *
 * @method SymfonyApiVersion getObject() Returns the current form's model object
 *
 * @package    plugintracker
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseSymfonyApiVersionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'name'                => new sfWidgetFormInputText(),
      'created_at'          => new sfWidgetFormDateTime(),
      'updated_at'          => new sfWidgetFormDateTime(),
      'plugin_release_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'PluginRelease')),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'name'                => new sfValidatorString(array('max_length' => 5)),
      'created_at'          => new sfValidatorDateTime(),
      'updated_at'          => new sfValidatorDateTime(),
      'plugin_release_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'PluginRelease', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('symfony_api_version[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'SymfonyApiVersion';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['plugin_release_list']))
    {
      $this->setDefault('plugin_release_list', $this->object->PluginRelease->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->savePluginReleaseList($con);

    parent::doSave($con);
  }

  public function savePluginReleaseList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['plugin_release_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->PluginRelease->getPrimaryKeys();
    $values = $this->getValue('plugin_release_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('PluginRelease', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('PluginRelease', array_values($link));
    }
  }

}

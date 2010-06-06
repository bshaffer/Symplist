<?php

/**
 * PluginRelease form base class.
 *
 * @method PluginRelease getObject() Returns the current form's model object
 *
 * @package    plugintracker
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BasePluginReleaseForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'plugin_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Plugin'), 'add_empty' => false)),
      'version'           => new sfWidgetFormInputText(),
      'date'              => new sfWidgetFormDateTime(),
      'summary'           => new sfWidgetFormTextarea(),
      'stability'         => new sfWidgetFormChoice(array('choices' => array('alpha' => 'alpha', 'beta' => 'beta', 'stable' => 'stable'))),
      'readme'            => new sfWidgetFormTextarea(),
      'dependencies'      => new sfWidgetFormInputText(),
      'created_at'        => new sfWidgetFormDateTime(),
      'updated_at'        => new sfWidgetFormDateTime(),
      'position'          => new sfWidgetFormInputText(),
      'api_versions_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'SymfonyApiVersion')),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'plugin_id'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Plugin'))),
      'version'           => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'date'              => new sfValidatorDateTime(array('required' => false)),
      'summary'           => new sfValidatorString(array('required' => false)),
      'stability'         => new sfValidatorChoice(array('choices' => array(0 => 'alpha', 1 => 'beta', 2 => 'stable'), 'required' => false)),
      'readme'            => new sfValidatorString(array('required' => false)),
      'dependencies'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'        => new sfValidatorDateTime(),
      'updated_at'        => new sfValidatorDateTime(),
      'position'          => new sfValidatorInteger(array('required' => false)),
      'api_versions_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'SymfonyApiVersion', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'PluginRelease', 'column' => array('position', 'plugin_id')))
    );

    $this->widgetSchema->setNameFormat('plugin_release[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'PluginRelease';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['api_versions_list']))
    {
      $this->setDefault('api_versions_list', $this->object->ApiVersions->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveApiVersionsList($con);

    parent::doSave($con);
  }

  public function saveApiVersionsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['api_versions_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->ApiVersions->getPrimaryKeys();
    $values = $this->getValue('api_versions_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('ApiVersions', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('ApiVersions', array_values($link));
    }
  }

}

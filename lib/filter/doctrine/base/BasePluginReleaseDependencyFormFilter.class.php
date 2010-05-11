<?php

/**
 * PluginReleaseDependency filter form base class.
 *
 * @package    plugintracker
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BasePluginReleaseDependencyFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'release_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Release'), 'add_empty' => true)),
      'dependency_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Dependency'), 'add_empty' => true)),
      'dependency_version_min' => new sfWidgetFormFilterInput(),
      'dependency_version_max' => new sfWidgetFormFilterInput(),
      'created_at'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'release_id'             => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Release'), 'column' => 'id')),
      'dependency_id'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Dependency'), 'column' => 'id')),
      'dependency_version_min' => new sfValidatorPass(array('required' => false)),
      'dependency_version_max' => new sfValidatorPass(array('required' => false)),
      'created_at'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('plugin_release_dependency_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'PluginReleaseDependency';
  }

  public function getFields()
  {
    return array(
      'id'                     => 'Number',
      'release_id'             => 'ForeignKey',
      'dependency_id'          => 'ForeignKey',
      'dependency_version_min' => 'Text',
      'dependency_version_max' => 'Text',
      'created_at'             => 'Date',
      'updated_at'             => 'Date',
    );
  }
}

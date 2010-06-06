<?php

/**
 * PluginRelease filter form base class.
 *
 * @package    plugintracker
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BasePluginReleaseFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'plugin_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Plugin'), 'add_empty' => true)),
      'version'           => new sfWidgetFormFilterInput(),
      'date'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'summary'           => new sfWidgetFormFilterInput(),
      'stability'         => new sfWidgetFormChoice(array('choices' => array('' => '', 'alpha' => 'alpha', 'beta' => 'beta', 'stable' => 'stable'))),
      'readme'            => new sfWidgetFormFilterInput(),
      'dependencies'      => new sfWidgetFormFilterInput(),
      'created_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'position'          => new sfWidgetFormFilterInput(),
      'api_versions_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'SymfonyApiVersion')),
    ));

    $this->setValidators(array(
      'plugin_id'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Plugin'), 'column' => 'id')),
      'version'           => new sfValidatorPass(array('required' => false)),
      'date'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'summary'           => new sfValidatorPass(array('required' => false)),
      'stability'         => new sfValidatorChoice(array('required' => false, 'choices' => array('alpha' => 'alpha', 'beta' => 'beta', 'stable' => 'stable'))),
      'readme'            => new sfValidatorPass(array('required' => false)),
      'dependencies'      => new sfValidatorPass(array('required' => false)),
      'created_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'position'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'api_versions_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'SymfonyApiVersion', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('plugin_release_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addApiVersionsListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query->leftJoin('r.PluginReleaseSymfonyApiVersion PluginReleaseSymfonyApiVersion')
          ->andWhereIn('PluginReleaseSymfonyApiVersion.api_version_id', $values);
  }

  public function getModelName()
  {
    return 'PluginRelease';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'plugin_id'         => 'ForeignKey',
      'version'           => 'Text',
      'date'              => 'Date',
      'summary'           => 'Text',
      'stability'         => 'Enum',
      'readme'            => 'Text',
      'dependencies'      => 'Text',
      'created_at'        => 'Date',
      'updated_at'        => 'Date',
      'position'          => 'Number',
      'api_versions_list' => 'ManyKey',
    );
  }
}

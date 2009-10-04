<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * PluginRelease filter form base class.
 *
 * @package    filters
 * @subpackage PluginRelease *
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class BasePluginReleaseFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'plugin_id'           => new sfWidgetFormDoctrineChoice(array('model' => 'SymfonyPlugin', 'add_empty' => true)),
      'version'             => new sfWidgetFormFilterInput(),
      'date'                => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'symfony_version_min' => new sfWidgetFormFilterInput(),
      'symfony_version_max' => new sfWidgetFormFilterInput(),
      'summary'             => new sfWidgetFormFilterInput(),
      'stability'           => new sfWidgetFormFilterInput(),
      'readme'              => new sfWidgetFormFilterInput(),
      'dependencies'        => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'plugin_id'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'SymfonyPlugin', 'column' => 'id')),
      'version'             => new sfValidatorPass(array('required' => false)),
      'date'                => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'symfony_version_min' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'symfony_version_max' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'summary'             => new sfValidatorPass(array('required' => false)),
      'stability'           => new sfValidatorPass(array('required' => false)),
      'readme'              => new sfValidatorPass(array('required' => false)),
      'dependencies'        => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('plugin_release_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PluginRelease';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Number',
      'plugin_id'           => 'ForeignKey',
      'version'             => 'Text',
      'date'                => 'Date',
      'symfony_version_min' => 'Number',
      'symfony_version_max' => 'Number',
      'summary'             => 'Text',
      'stability'           => 'Text',
      'readme'              => 'Text',
      'dependencies'        => 'Text',
    );
  }
}
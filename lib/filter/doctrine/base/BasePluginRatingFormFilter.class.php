<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * PluginRating filter form base class.
 *
 * @package    filters
 * @subpackage PluginRating *
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class BasePluginRatingFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'symfony_plugin_id' => new sfWidgetFormDoctrineChoice(array('model' => 'SymfonyPlugin', 'add_empty' => true)),
      'sf_guard_user_id'  => new sfWidgetFormDoctrineChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'rating'            => new sfWidgetFormFilterInput(),
      'created_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'updated_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
    ));

    $this->setValidators(array(
      'symfony_plugin_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'SymfonyPlugin', 'column' => 'id')),
      'sf_guard_user_id'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
      'rating'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('plugin_rating_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PluginRating';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'symfony_plugin_id' => 'ForeignKey',
      'sf_guard_user_id'  => 'ForeignKey',
      'rating'            => 'Number',
      'created_at'        => 'Date',
      'updated_at'        => 'Date',
    );
  }
}
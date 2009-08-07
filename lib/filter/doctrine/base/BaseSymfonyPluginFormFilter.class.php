<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * SymfonyPlugin filter form base class.
 *
 * @package    filters
 * @subpackage SymfonyPlugin *
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class BaseSymfonyPluginFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'title'       => new sfWidgetFormFilterInput(),
      'description' => new sfWidgetFormFilterInput(),
      'author_id'   => new sfWidgetFormDoctrineChoice(array('model' => 'PluginAuthor', 'add_empty' => true)),
      'category_id' => new sfWidgetFormDoctrineChoice(array('model' => 'PluginCategory', 'add_empty' => true)),
      'active'      => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'slug'        => new sfWidgetFormFilterInput(),
      'created_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'updated_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
    ));

    $this->setValidators(array(
      'title'       => new sfValidatorPass(array('required' => false)),
      'description' => new sfValidatorPass(array('required' => false)),
      'author_id'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'PluginAuthor', 'column' => 'id')),
      'category_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'PluginCategory', 'column' => 'id')),
      'active'      => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'slug'        => new sfValidatorPass(array('required' => false)),
      'created_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('symfony_plugin_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SymfonyPlugin';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'title'       => 'Text',
      'description' => 'Text',
      'author_id'   => 'ForeignKey',
      'category_id' => 'ForeignKey',
      'active'      => 'Boolean',
      'slug'        => 'Text',
      'created_at'  => 'Date',
      'updated_at'  => 'Date',
    );
  }
}
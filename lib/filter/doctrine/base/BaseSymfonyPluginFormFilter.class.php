<?php

/**
 * SymfonyPlugin filter form base class.
 *
 * @package    plugintracker
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id$
 */
class BaseSymfonyPluginFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'title'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'description'       => new sfWidgetFormFilterInput(),
      'user_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => true)),
      'symfony_developer' => new sfWidgetFormFilterInput(),
      'category_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Category'), 'add_empty' => true)),
      'active'            => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'repository'        => new sfWidgetFormFilterInput(),
      'image'             => new sfWidgetFormFilterInput(),
      'homepage'          => new sfWidgetFormFilterInput(),
      'ticketing'         => new sfWidgetFormFilterInput(),
      'featured'          => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'slug'              => new sfWidgetFormFilterInput(),
      'created_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'raters_list'       => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardUser')),
    ));

    $this->setValidators(array(
      'title'             => new sfValidatorPass(array('required' => false)),
      'description'       => new sfValidatorPass(array('required' => false)),
      'user_id'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('User'), 'column' => 'id')),
      'symfony_developer' => new sfValidatorPass(array('required' => false)),
      'category_id'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Category'), 'column' => 'id')),
      'active'            => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'repository'        => new sfValidatorPass(array('required' => false)),
      'image'             => new sfValidatorPass(array('required' => false)),
      'homepage'          => new sfValidatorPass(array('required' => false)),
      'ticketing'         => new sfValidatorPass(array('required' => false)),
      'featured'          => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'slug'              => new sfValidatorPass(array('required' => false)),
      'created_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'raters_list'       => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'sfGuardUser', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('symfony_plugin_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addRatersListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query->leftJoin('r.PluginRating PluginRating')
          ->andWhereIn('PluginRating.sf_guard_user_id', $values);
  }

  public function getModelName()
  {
    return 'SymfonyPlugin';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'title'             => 'Text',
      'description'       => 'Text',
      'user_id'           => 'ForeignKey',
      'symfony_developer' => 'Text',
      'category_id'       => 'ForeignKey',
      'active'            => 'Boolean',
      'repository'        => 'Text',
      'image'             => 'Text',
      'homepage'          => 'Text',
      'ticketing'         => 'Text',
      'featured'          => 'Boolean',
      'slug'              => 'Text',
      'created_at'        => 'Date',
      'updated_at'        => 'Date',
      'raters_list'       => 'ManyKey',
    );
  }
}

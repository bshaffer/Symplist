<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * Comment filter form base class.
 *
 * @package    filters
 * @subpackage Comment *
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class BaseCommentFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'body'                => new sfWidgetFormFilterInput(),
      'approved'            => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'approved_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'user_id'             => new sfWidgetFormDoctrineChoice(array('model' => 'Commenter', 'add_empty' => true)),
      'root_id'             => new sfWidgetFormFilterInput(),
      'lft'                 => new sfWidgetFormFilterInput(),
      'rgt'                 => new sfWidgetFormFilterInput(),
      'level'               => new sfWidgetFormFilterInput(),
      'created_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'updated_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'symfony_plugin_list' => new sfWidgetFormDoctrineChoiceMany(array('model' => 'SymfonyPlugin')),
    ));

    $this->setValidators(array(
      'body'                => new sfValidatorPass(array('required' => false)),
      'approved'            => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'approved_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'user_id'             => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'Commenter', 'column' => 'id')),
      'root_id'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'lft'                 => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'rgt'                 => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'level'               => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'symfony_plugin_list' => new sfValidatorDoctrineChoiceMany(array('model' => 'SymfonyPlugin', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('comment_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addSymfonyPluginListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query->leftJoin('r.SymfonyPluginComment SymfonyPluginComment')
          ->andWhereIn('SymfonyPluginComment.id', $values);
  }

  public function getModelName()
  {
    return 'Comment';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Number',
      'body'                => 'Text',
      'approved'            => 'Boolean',
      'approved_at'         => 'Date',
      'user_id'             => 'ForeignKey',
      'root_id'             => 'Number',
      'lft'                 => 'Number',
      'rgt'                 => 'Number',
      'level'               => 'Number',
      'created_at'          => 'Date',
      'updated_at'          => 'Date',
      'symfony_plugin_list' => 'ManyKey',
    );
  }
}
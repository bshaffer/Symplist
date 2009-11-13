<?php

/**
 * Comment filter form base class.
 *
 * @package    plugintracker
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id$
 */
class BaseCommentFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'body'                  => new sfWidgetFormFilterInput(),
      'approved'              => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'approved_at'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'user_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Commenter'), 'add_empty' => true)),
      'authenticated_user_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('AuthenticatedUser'), 'add_empty' => true)),
      'root_id'               => new sfWidgetFormFilterInput(),
      'lft'                   => new sfWidgetFormFilterInput(),
      'rgt'                   => new sfWidgetFormFilterInput(),
      'level'                 => new sfWidgetFormFilterInput(),
      'created_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'body'                  => new sfValidatorPass(array('required' => false)),
      'approved'              => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'approved_at'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'user_id'               => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Commenter'), 'column' => 'id')),
      'authenticated_user_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('AuthenticatedUser'), 'column' => 'id')),
      'root_id'               => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'lft'                   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'rgt'                   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'level'                 => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('comment_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Comment';
  }

  public function getFields()
  {
    return array(
      'id'                    => 'Number',
      'body'                  => 'Text',
      'approved'              => 'Boolean',
      'approved_at'           => 'Date',
      'user_id'               => 'ForeignKey',
      'authenticated_user_id' => 'ForeignKey',
      'root_id'               => 'Number',
      'lft'                   => 'Number',
      'rgt'                   => 'Number',
      'level'                 => 'Number',
      'created_at'            => 'Date',
      'updated_at'            => 'Date',
    );
  }
}

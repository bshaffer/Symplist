<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * CommunityListItem filter form base class.
 *
 * @package    filters
 * @subpackage CommunityListItem *
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class BaseCommunityListItemFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'title'        => new sfWidgetFormFilterInput(),
      'body'         => new sfWidgetFormFilterInput(),
      'list_id'      => new sfWidgetFormDoctrineChoice(array('model' => 'CommunityList', 'add_empty' => true)),
      'score'        => new sfWidgetFormFilterInput(),
      'count'        => new sfWidgetFormFilterInput(),
      'submitted_by' => new sfWidgetFormDoctrineChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'created_at'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'updated_at'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'body_html'    => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'title'        => new sfValidatorPass(array('required' => false)),
      'body'         => new sfValidatorPass(array('required' => false)),
      'list_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'CommunityList', 'column' => 'id')),
      'score'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'count'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'submitted_by' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
      'created_at'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'body_html'    => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('community_list_item_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CommunityListItem';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'title'        => 'Text',
      'body'         => 'Text',
      'list_id'      => 'ForeignKey',
      'score'        => 'Number',
      'count'        => 'Number',
      'submitted_by' => 'ForeignKey',
      'created_at'   => 'Date',
      'updated_at'   => 'Date',
      'body_html'    => 'Text',
    );
  }
}
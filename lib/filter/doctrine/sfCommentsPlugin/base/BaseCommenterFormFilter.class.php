<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * Commenter filter form base class.
 *
 * @package    filters
 * @subpackage Commenter *
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class BaseCommenterFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'username' => new sfWidgetFormFilterInput(),
      'email'    => new sfWidgetFormFilterInput(),
      'website'  => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'username' => new sfValidatorPass(array('required' => false)),
      'email'    => new sfValidatorPass(array('required' => false)),
      'website'  => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('commenter_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Commenter';
  }

  public function getFields()
  {
    return array(
      'id'       => 'Number',
      'username' => 'Text',
      'email'    => 'Text',
      'website'  => 'Text',
    );
  }
}
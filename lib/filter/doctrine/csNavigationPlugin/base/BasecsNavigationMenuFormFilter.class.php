<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * csNavigationMenu filter form base class.
 *
 * @package    filters
 * @subpackage csNavigationMenu *
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class BasecsNavigationMenuFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'title'       => new sfWidgetFormFilterInput(),
      'description' => new sfWidgetFormFilterInput(),
      'root_id'     => new sfWidgetFormDoctrineChoice(array('model' => 'csNavigationItem', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'title'       => new sfValidatorPass(array('required' => false)),
      'description' => new sfValidatorPass(array('required' => false)),
      'root_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'csNavigationItem', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('cs_navigation_menu_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'csNavigationMenu';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'title'       => 'Text',
      'description' => 'Text',
      'root_id'     => 'ForeignKey',
    );
  }
}
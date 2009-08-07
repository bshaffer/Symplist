<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * csNavigationItem filter form base class.
 *
 * @package    plugintracker
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id$
 */
class BasecsNavigationItemFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'      => new sfWidgetFormFilterInput(),
      'route'     => new sfWidgetFormFilterInput(),
      'protected' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'locked'    => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'root_id'   => new sfWidgetFormFilterInput(),
      'lft'       => new sfWidgetFormFilterInput(),
      'rgt'       => new sfWidgetFormFilterInput(),
      'level'     => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'name'      => new sfValidatorPass(array('required' => false)),
      'route'     => new sfValidatorPass(array('required' => false)),
      'protected' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'locked'    => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'root_id'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'lft'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'rgt'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'level'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('cs_navigation_item_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'csNavigationItem';
  }

  public function getFields()
  {
    return array(
      'id'        => 'Number',
      'name'      => 'Text',
      'route'     => 'Text',
      'protected' => 'Boolean',
      'locked'    => 'Boolean',
      'root_id'   => 'Number',
      'lft'       => 'Number',
      'rgt'       => 'Number',
      'level'     => 'Number',
    );
  }
}

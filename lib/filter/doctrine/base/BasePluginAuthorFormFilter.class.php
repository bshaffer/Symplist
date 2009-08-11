<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * PluginAuthor filter form base class.
 *
 * @package    filters
 * @subpackage PluginAuthor *
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class BasePluginAuthorFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'first_name'       => new sfWidgetFormFilterInput(),
      'last_name'        => new sfWidgetFormFilterInput(),
      'email'            => new sfWidgetFormFilterInput(),
      'bio'              => new sfWidgetFormFilterInput(),
      'sf_guard_user_id' => new sfWidgetFormDoctrineChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'first_name'       => new sfValidatorPass(array('required' => false)),
      'last_name'        => new sfValidatorPass(array('required' => false)),
      'email'            => new sfValidatorPass(array('required' => false)),
      'bio'              => new sfValidatorPass(array('required' => false)),
      'sf_guard_user_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
    ));

    $this->widgetSchema->setNameFormat('plugin_author_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PluginAuthor';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'first_name'       => 'Text',
      'last_name'        => 'Text',
      'email'            => 'Text',
      'bio'              => 'Text',
      'sf_guard_user_id' => 'ForeignKey',
    );
  }
}
<?php

/**
 * SeoPage form base class.
 *
 * @package    plugintracker
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id$
 */
class BaseSeoPageForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'url'                  => new sfWidgetFormInput(),
      'title'                => new sfWidgetFormInput(),
      'description'          => new sfWidgetFormTextarea(),
      'keywords'             => new sfWidgetFormInput(),
      'priority'             => new sfWidgetFormInput(),
      'changeFreq'           => new sfWidgetFormChoice(array('choices' => array('always' => 'always', 'hourly' => 'hourly', 'daily' => 'daily', 'weekly' => 'weekly', 'monthly' => 'monthly', 'yearly' => 'yearly', 'never' => 'never'))),
      'exclude_from_sitemap' => new sfWidgetFormInputCheckbox(),
      'created_at'           => new sfWidgetFormDateTime(),
      'updated_at'           => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorDoctrineChoice(array('model' => 'SeoPage', 'column' => 'id', 'required' => false)),
      'url'                  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'title'                => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'description'          => new sfValidatorString(array('required' => false)),
      'keywords'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'priority'             => new sfValidatorNumber(array('required' => false)),
      'changeFreq'           => new sfValidatorChoice(array('choices' => array('always' => 'always', 'hourly' => 'hourly', 'daily' => 'daily', 'weekly' => 'weekly', 'monthly' => 'monthly', 'yearly' => 'yearly', 'never' => 'never'), 'required' => false)),
      'exclude_from_sitemap' => new sfValidatorBoolean(array('required' => false)),
      'created_at'           => new sfValidatorDateTime(),
      'updated_at'           => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('seo_page[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'SeoPage';
  }

}

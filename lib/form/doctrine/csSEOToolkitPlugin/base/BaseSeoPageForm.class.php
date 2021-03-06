<?php

/**
 * SeoPage form base class.
 *
 * @method SeoPage getObject() Returns the current form's model object
 *
 * @package    plugintracker
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseSeoPageForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'url'                  => new sfWidgetFormInputText(),
      'title'                => new sfWidgetFormInputText(),
      'description'          => new sfWidgetFormTextarea(),
      'keywords'             => new sfWidgetFormInputText(),
      'priority'             => new sfWidgetFormInputText(),
      'changeFreq'           => new sfWidgetFormChoice(array('choices' => array('always' => 'always', 'hourly' => 'hourly', 'daily' => 'daily', 'weekly' => 'weekly', 'monthly' => 'monthly', 'yearly' => 'yearly', 'never' => 'never'))),
      'exclude_from_sitemap' => new sfWidgetFormInputCheckbox(),
      'created_at'           => new sfWidgetFormDateTime(),
      'updated_at'           => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'url'                  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'title'                => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'description'          => new sfValidatorString(array('required' => false)),
      'keywords'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'priority'             => new sfValidatorNumber(array('required' => false)),
      'changeFreq'           => new sfValidatorChoice(array('choices' => array(0 => 'always', 1 => 'hourly', 2 => 'daily', 3 => 'weekly', 4 => 'monthly', 5 => 'yearly', 6 => 'never'), 'required' => false)),
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

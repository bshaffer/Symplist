<?php

/**
 * SeoPage filter form base class.
 *
 * @package    plugintracker
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseSeoPageFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'url'                  => new sfWidgetFormFilterInput(),
      'title'                => new sfWidgetFormFilterInput(),
      'description'          => new sfWidgetFormFilterInput(),
      'keywords'             => new sfWidgetFormFilterInput(),
      'priority'             => new sfWidgetFormFilterInput(),
      'changeFreq'           => new sfWidgetFormChoice(array('choices' => array('' => '', 'always' => 'always', 'hourly' => 'hourly', 'daily' => 'daily', 'weekly' => 'weekly', 'monthly' => 'monthly', 'yearly' => 'yearly', 'never' => 'never'))),
      'exclude_from_sitemap' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'url'                  => new sfValidatorPass(array('required' => false)),
      'title'                => new sfValidatorPass(array('required' => false)),
      'description'          => new sfValidatorPass(array('required' => false)),
      'keywords'             => new sfValidatorPass(array('required' => false)),
      'priority'             => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'changeFreq'           => new sfValidatorChoice(array('required' => false, 'choices' => array('always' => 'always', 'hourly' => 'hourly', 'daily' => 'daily', 'weekly' => 'weekly', 'monthly' => 'monthly', 'yearly' => 'yearly', 'never' => 'never'))),
      'exclude_from_sitemap' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('seo_page_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'SeoPage';
  }

  public function getFields()
  {
    return array(
      'id'                   => 'Number',
      'url'                  => 'Text',
      'title'                => 'Text',
      'description'          => 'Text',
      'keywords'             => 'Text',
      'priority'             => 'Number',
      'changeFreq'           => 'Enum',
      'exclude_from_sitemap' => 'Boolean',
      'created_at'           => 'Date',
      'updated_at'           => 'Date',
    );
  }
}

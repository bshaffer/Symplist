<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * SeoPage filter form base class.
 *
 * @package    filters
 * @subpackage SeoPage *
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class BaseSeoPageFormFilter extends BaseFormFilterDoctrine
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
      'created_at'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'updated_at'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
    ));

    $this->setValidators(array(
      'url'                  => new sfValidatorPass(array('required' => false)),
      'title'                => new sfValidatorPass(array('required' => false)),
      'description'          => new sfValidatorPass(array('required' => false)),
      'keywords'             => new sfValidatorPass(array('required' => false)),
      'priority'             => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'changeFreq'           => new sfValidatorChoice(array('required' => false, 'choices' => array('always' => 'always', 'hourly' => 'hourly', 'daily' => 'daily', 'weekly' => 'weekly', 'monthly' => 'monthly', 'yearly' => 'yearly', 'never' => 'never'))),
      'exclude_from_sitemap' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('seo_page_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

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
<?php

/**
 * CommunityList form.
 *
 * @package    form
 * @subpackage CommunityList
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class CommunityListForm extends BaseCommunityListForm
{
  public function configure()
  {
    // parent::configure();
    unset($this['description_html'], $this['created_at'], $this['updated_at'], $this['featured']);
    $this->widgetSchema->setHelp('description', 'This Editor uses <a href="http://daringfireball.net/projects/markdown/">Markdown</a>');
    $this->widgetSchema['description']->setAttributes(array('cols' => '68', 'rows' => '10'));
    $this->widgetSchema['submitted_by'] = new sfWidgetFormInputHidden();
    $this->setDefault('submitted_by', sfContext::getInstance()->getUser()->getId());
  }
}
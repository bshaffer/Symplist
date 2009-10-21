<?php

/**
 * CommunityListItem form.
 *
 * @package    form
 * @subpackage CommunityListItem
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class CommunityListItemForm extends BaseCommunityListItemForm
{
  public function configure()
  {
    unset($this['created_at'], $this['score'], $this['count'], $this['body_html']);
    $this->widgetSchema['list_id'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['submitted_by'] = new sfWidgetFormInputHidden();
    $this->widgetSchema->setHelp('body', 'This Editor uses <a href="http://daringfireball.net/projects/markdown/">Markdown</a>');
    $this->setDefault('submitted_by', sfContext::getInstance()->getUser()->getId());
  }
}
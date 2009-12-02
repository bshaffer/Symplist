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
    $this->widgetSchema['body'] = new sfWidgetFormTextarea(array(), array('rows' => 10, 'cols' => 60));
    $this->widgetSchema->setHelp('body', 'This Editor uses <a href="http://daringfireball.net/projects/markdown/" target="_blank">Markdown</a>');
    $this->setDefault('submitted_by', sfContext::getInstance()->getUser()->getId());
  }
}
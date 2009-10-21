<?php

/**
 * CommunityListItem form.
 *
 * @package    form
 * @subpackage CommunityListItem
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class InlineCommunityListItemForm extends CommunityListItemForm
{
  public function configure()
  {
    parent::configure();
    $this->widgetSchema->setNameFormat('community_list_item['.rand().'][%s]');
  }
}
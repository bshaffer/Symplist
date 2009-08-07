<?php

/**
 * PluginComment form.
 *
 * @package    form
 * @subpackage Comment
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
abstract class PluginCommentForm extends BaseCommentForm
{
  public function configure()
  {
    parent::configure();
    
    $this->setWidgets(array(
        'body'      => new sfWidgetFormTextarea(),
      ));
      
    $this->setValidators(array(
        'body'      => new sfValidatorString(),
      ));    

    $this->embedForm('Commenter', new CommenterForm($this->getObject()->getCommenter())); 

    $this->widgetSchema->setLabel('body', 'Your Comment');
      
    $this->widgetSchema->setNameFormat('comment[%s]');
  }

}
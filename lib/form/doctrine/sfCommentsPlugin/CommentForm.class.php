<?php

/**
 * Comment form.
 *
 * @package    plugintracker
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id$
 */
class CommentForm extends PluginCommentForm
{
  public function configure()
  {
    parent::configure();
    $this->widgetSchema['body'] = new sfWidgetFormTextarea(array(), array('cols' => 32));
    // $this->widgetSchema['rating'] = new sfWidgetFormStarRating();
    // $this->validatorSchema['rating'] = new sfValidatorInteger(array('min' => 1, 'max' => 5));
  }
}

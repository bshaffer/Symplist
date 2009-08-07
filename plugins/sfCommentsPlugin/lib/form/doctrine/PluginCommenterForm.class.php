<?php

/**
 * PluginCommenter form.
 *
 * @package    form
 * @subpackage Commenter
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
abstract class PluginCommenterForm extends BaseCommenterForm
{
  public function configure()
  {
    parent::configure();
    $this->validatorSchema['email'] = new sfValidatorEmail(array('required' => false));
  }
}
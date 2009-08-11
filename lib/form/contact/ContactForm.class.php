<?php

/**
* Contact Form Class
*/
class ContactForm extends sfForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'name'        => new sfWidgetFormInput(),
      'email'       => new sfWidgetFormInput(),
      'message'     => new sfWidgetFormTextarea()
      ));
    
    $this->setValidators(array(
      'name'        => new sfValidatorString(),
      'email'       => new sfValidatorString(),
      'message'     => new sfValidatorString()
      ));
      
    $this->widgetSchema->setNameFormat('contact[%s]');
  }
}

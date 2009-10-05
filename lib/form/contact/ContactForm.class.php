<?php

/**
* Contact Form Class
*/
class ContactForm extends BaseForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'name'        => new sfWidgetFormInputText(),
      'email'       => new sfWidgetFormInputText(),
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

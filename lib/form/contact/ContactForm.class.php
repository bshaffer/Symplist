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
      'email'       => new sfValidatorEmail(),
      'message'     => new sfValidatorString()
    ));
    
    $this->validatorSchema['email']->setMessage('invalid', 'Please enter a valid email address');
      
    $this->widgetSchema->setNameFormat('contact[%s]');
  }
}

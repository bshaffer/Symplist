<?php

/**
 * sfSwiftMailer actions.
 *
 * @package    sfSwiftMailer
 * @subpackage 
 * @author     Jason Ibele
 * @version    SVN: $Id: actions.class.php 1814 2006-08-24 12:20:11Z Draven $
 */
class sfSwiftMailerActions extends sfActions
{
  
  /**
   * Example of sending a multipart email using SMTP
   *
   */
  public function executeThankYou()
  {
    // Create our connection, in this case an SMTP connection
    $conn   = new Swift_Connection_SMTP( sfConfig::get('mod_sfswiftmailer_smtp_host') );

    // Need auth for SMTP
    $conn->setUsername( sfConfig::get('mod_sfswiftmailer_smtp_user') );
    $conn->setPassword( sfConfig::get('mod_sfswiftmailer_smtp_pass') );

    $mailer = new Swift($conn);

    // Get our message bodies
    $htmlBody = $this->getPresentationFor('sfSwiftMailer', 'thankYouHtml');
    $textBody = $this->getPresentationFor('sfSwiftMailer', 'thankYouText');

		//Create a message
		$message = new Swift_Message("The Subject");

		//Add some "parts"
		$message->attach(new Swift_Message_Part($textBody));
		$message->attach(new Swift_Message_Part($htmlBody, "text/html"));

    // Send out our mailer
    $mailer->send($message, 'recipient@some.com', 'sender@some.com');
    $mailer->disconnect();

    return sfView:: SUCCESS;
  }
  
  /**
   * Action for the HTML body of multipart email
   *
   */
  public function executeThankYouHtml()
  {
    // execute whatever code we need to include varaibles to templates
    
    return sfView::SUCCESS;
  }
  
  /**
   * Action for the Text body of multipart email
   *
   */
  public function executeThankYouText()
  {
    // execute whatever code we need to include varaibles to templates
    
    return sfView::SUCCESS;
  }

}

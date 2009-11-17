<?php

// require_once sfConfig::get('sf_lib_dir').'/vendor/swift/swift_init.php'; 

/**
*  Swift Mailer Helper Class
*/
class EmailHelper
{
	static function sendEmail($params)
	{
		$mailTo = $params['to'];
 		$mailFrom = $params['from'];
    try
    {
      // Create the Mail Object
      $transport = new Swift_SendmailTransport();
      $mailer = Swift_Mailer::newInstance($transport);
      $message = Swift_Message::newInstance($params['subject'], $params['body'], 'text/html')
                ->setTo($params['to'])
                ->setFrom($params['from']);

      // Send
      return $mailer->send($message);
    }
    catch(Exception $e)
    {
      $mailer->disconnect();
      echo 'Error: ' . $e;
    }
	}
}

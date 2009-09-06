<li><?php echo link_to('my profile', '@author?username='.$sf_user->getGuardUser()->getUsername()) ?></li>
<li><?php echo link_to('register a plugin', '@plugin_register') ?></li>
<li><?php echo link_to('sign out', '@signout_redirect') ?></li>
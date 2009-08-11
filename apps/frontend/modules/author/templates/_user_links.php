<li><?php echo link_to('view profile', '@author?username='.$sf_user->getGuardUser()->getUsername()) ?></li>
<li><?php echo link_to('edit profile', '@author_edit?username='.$sf_user->getGuardUser()->getUsername()) ?></li>
<li><?php echo link_to('register a plugin', '@plugin_new') ?></li>
<li><?php echo link_to('sign out', '@signout_redirect') ?></li>
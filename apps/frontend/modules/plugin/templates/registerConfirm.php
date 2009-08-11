<h1>Thank you for registering <?php echo $plugin['title'] ?>!</h1>
<ul>
  <li><?php echo link_to('Return to plugin page', $plugin->getRoute()) ?></li>
  <li><?php echo link_to('View your profile', $user->getRoute()) ?></li>  
  <li><?php echo link_to('Browse Plugins', '@plugin_categories') ?></li>    
</ul>
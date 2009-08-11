<ul>
<li><?php echo link_to('edit profile', '@author_edit?username='.$user['username']) ?></li>
<li><?php echo link_to('view profile', '@author?username='.$user['username']) ?></li>
<li><?php echo link_to('register a plugin', '@plugin_new') ?></li>
</ul>
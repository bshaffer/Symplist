<?php if ($sf_user->isAuthenticated()): ?>
	<ul id='main-nav'>
		<li><?php echo link_to('Plugins', '@symfony_plugin') ?></li>	  
		<li><?php echo link_to('Approve Comments', '@comment_csCommentAdmin') ?></li>
	</ul>	
<?php endif ?>

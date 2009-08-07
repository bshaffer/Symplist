<?php if ($sf_user->isAuthenticated()): ?>
	<ul id='main-nav'>
		<li><?php echo link_to('Approve Comments', '@comment_csCommentAdmin') ?></li>
		<li><?php echo link_to('Link 2', '@homepage') ?></li>
	</ul>	
<?php endif ?>

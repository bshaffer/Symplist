<ul id='secondary-nav'>
  <?php if ($sf_user->isAuthenticated()): ?>
    <?php include_partial('author/user_links') ?>
  <?php else: ?>
    <li><?php echo link_to('sign in', '@signin') ?></li>
    <li><?php echo link_to('register', '@author_new') ?></li>          
  <?php endif ?>
</ul>

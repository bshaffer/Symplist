<ul id='nav-utility'>
  <?php if ($sf_user->isAuthenticated()): ?>
    <li><?php echo link_to('My Profile', '@author?username='.$sf_user->getGuardUser()->getUsername()) ?></li>
    <li><?php echo link_to('Sign Out', '@signout_redirect') ?></li>
  <?php else: ?>
    <li><?php echo link_to('Sign In', '@signin') ?></li>
    <li><?php echo link_to('Register', '@author_new') ?></li>          
  <?php endif ?>
</ul>

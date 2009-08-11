<h1>Developers</h1>
<span class='join'><?php echo link_to('Create an account', '@author_new') ?></span>
<h3>Recently Active</h3>
<ul class='recently-active'>
<?php foreach ($recentlyActive as $user): ?>
  <li>
    <?php echo link_to($user->getUsername(), $user->getRoute()) ?>
  </li>
<?php endforeach ?>
</ul>
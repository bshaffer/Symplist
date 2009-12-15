<?php use_helper('Pager') ?>

<h2>All Developers</h2>

<ul class='developers all-developers'>
<?php foreach ($users as $user): ?>
  <li>
    <?php echo link_to($user->getUsername(), $user->getRoute()) ?>
    (<?php echo $user['Plugins']->count().($user['Plugins']->count() == 1 ? ' plugin' : ' plugins') ?>)
  </li>
<?php endforeach ?>
</ul>

<h1><?php echo $user->getUsername() ?></h1>
<?php if ($user['Author']): ?>
<p>
  <?php echo mail_to($user['Author']['email'], $user['Author']['first_name'].' '.$user['Author']['last_name']) ?>
</p>
<?php if (trim($user['Author']['bio'])): ?>
<p>
  <?php echo $user['Author']['bio'] ?>
</p>
<?php endif ?>
<?php endif ?>
<h3>Plugins</h3>
<?php if ($user['Plugins']->count() > 0): ?>
<ul>
<?php foreach ($user['Plugins'] as $plugin): ?>
  <li><?php include_partial('plugin/list_item', array('plugin' => $plugin)) ?></li>
<?php endforeach ?>
</ul>
<?php else: ?>
  <p>This user has yet to register any plugins</p>
<?php endif ?>

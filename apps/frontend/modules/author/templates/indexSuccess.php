<h2>Developers</h2>

<h3>Recently Active</h3>
<ul class='recently-active'>
<?php foreach ($recentlyActive as $user): ?>
  <li>
    <?php echo link_to($user->getUsername(), $user->getRoute()) ?>
  </li>
<?php endforeach ?>
</ul>
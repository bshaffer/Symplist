<h3>Recently Added</h3>
<ul>
<?php foreach ($plugins as $plugin): ?>
  <li>
    <?php include_partial('plugin/plugin', array('plugin' => $plugin)) ?>
  </li>
<?php endforeach ?>
</ul>
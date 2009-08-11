<h3>Highest Ranking</h1>
<ul>
<?php foreach ($plugins as $plugin): ?>
  <li>
    <?php include_partial('plugin/list_item', array('plugin' => $plugin)) ?>
  </li>
<?php endforeach ?>
</ul>
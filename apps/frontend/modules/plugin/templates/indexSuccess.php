<h2>All Plugins</h2>
<ul class='plugins-list'>
<?php foreach ($plugins as $plugin): ?>
  <li>
    <?php include_partial('plugin/list_item', array('plugin' => $plugin)) ?>
  </li>
<?php endforeach ?>
</ul>
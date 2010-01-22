<?php slot('title', 'View All Plugins') ?>

<h2>All Plugins</h2>
<ol class='plugins-list'>
<?php foreach ($plugins as $plugin): ?>
  <li>
    <?php echo link_to($plugin['title'], '@plugin?title='.$plugin['title']) ?>
  </li>
<?php endforeach ?>
</ol>
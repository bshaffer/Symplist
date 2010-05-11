<?php foreach ($featured as $plugin): ?>
  <div class="featured grid_3 alpha">
    <?php include_partial('plugin/plugin', array('plugin' => $plugin)) ?>
  </div>
<?php endforeach ?>

<?php slot('bottom_row') ?>

<div class="grid_4 alpha">
  <h3>Recently Added</h3>
  <ul>
  <?php foreach ($recent as $plugin): ?>
    <li>
      <?php include_partial('plugin/plugin', array('plugin' => $plugin)) ?>
    </li>
  <?php endforeach ?>
  </ul>
</div>

<div class="grid_4 alpha">
  <h3>Highest Ranking</h3>
  <ul>
  <?php foreach ($highest as $plugin): ?>
    <li>
      <?php include_partial('plugin/plugin', array('plugin' => $plugin)) ?>
    </li>
  <?php endforeach ?>
  </ul>
</div>


<div class="grid_4 alpha">
  <h3>Most Votes</h3> 
  <ul>
  <?php foreach ($votes as $plugin): ?>
    <li>
      <?php include_partial('plugin/plugin', array('plugin' => $plugin)) ?>
    </li>
  <?php endforeach ?>
  </ul>
</div>

<?php end_slot() ?>

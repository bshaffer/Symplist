<?php use_helper('Form') ?>

<?php foreach ($featured as $plugin): ?>
  <div class="featured grid_3 alpha">
    <?php include_partial('plugin/plugin', array('plugin' => $plugin)) ?>
  </div>
<?php endforeach ?>

<?php slot('bottom_row') ?>

<div class="grid_4 alpha">
  <?php include_component('plugin', 'highest_ranking', array('limit' => 5)) ?>
</div>

<div class="grid_4 alpha">
  <?php include_component('plugin', 'recently_added', array('limit' => 5)) ?>
</div>


<div class="grid_4 alpha">
  <?php include_component('plugin', 'most_votes', array('limit' => 5)) ?>
</div>

<?php end_slot() ?>

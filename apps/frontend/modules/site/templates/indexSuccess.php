<h1>Symfony Plugins</h1>

<p>
  Symplist currently has <?php echo $count ?> plugins registered.  Come be a part of the Symfony development community! 
</p>

<div id='highest-ranking' class='plugin-block'>
  <?php include_component('plugin', 'highest_ranking', array('limit' => 5)) ?>
</div>

<div id='recently-added' class='plugin-block'>
  <?php include_component('plugin', 'recently_added', array('limit' => 5)) ?>
</div>


<div id='most-votes' class='plugin-block'>
  <?php include_component('plugin', 'most_votes', array('limit' => 5)) ?>
</div>


<?php slot('right_column') ?>
  <h2>Search</h2>
  <?php include_partial('plugin/auto_complete_search', array()) ?>
<?php end_slot() ?>

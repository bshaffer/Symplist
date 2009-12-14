<div>
  <h3>Recently Added</h3>
  <ul>
  <?php foreach ($recent as $plugin): ?>
    <li>
      <h6><?php echo link_to($plugin['title'], $plugin['route'], array('class' => 'plugin-title')) ?></h6>
      <?php include_partial('plugin/rating', array('rating' => $plugin['rating'])) ?>
      <br />
    </li>
  <?php endforeach ?>
  </ul>
</div>

<div>
  <h3>Highest Ranking</h3>
  <ul>
  <?php foreach ($highest as $plugin): ?>
    <li>
      <h6><?php echo link_to($plugin['title'], $plugin['route'], array('class' => 'plugin-title')) ?></h6>
      <?php include_partial('plugin/rating', array('rating' => $plugin['rating'])) ?>
      <br />
    </li>
  <?php endforeach ?>
  </ul>
</div>


<div>
  <h3>Most Votes</h3> 
  <ul>
  <?php foreach ($votes as $plugin): ?>
    <li>
      <h6><?php echo link_to($plugin['title'], $plugin['route'], array('class' => 'plugin-title')) ?></h6>
      <?php include_partial('plugin/rating', array('rating' => $plugin['rating'])) ?>&nbsp;(<?php echo $plugin['num_votes'] ?> votes)
      <br />
    </li>
  <?php endforeach ?>
  </ul>
</div>

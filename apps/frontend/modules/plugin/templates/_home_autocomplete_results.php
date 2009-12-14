<?php if (count($results) == 0): ?>
  No Results
<?php else: ?>
<?php for ($i = 0; $i < count($results); $i++): ?>
  <?php $plugin = $results[$i] ?>
  <?php if ($i % 4 == 0): ?>
    <?php if ($i != 0): ?>
  </div>
    <?php endif ?>
  <div class='result-block grid_12 alpha omega'>
  <?php endif ?>
    <div class='featured grid_3 <?php echo $classes[$i%4] ?>'>
      <h6><?php echo link_to($plugin['title'], '@plugin?title='.$plugin['title'], array('class' => 'plugin-title')) ?></h6>
      <form class="rating">
        <?php for($j = 1; $j <= 5; $j++): ?>
        <input name="star1" type="radio" class="star" <?php echo ($plugin['rating'] == $j)?'checked':'' ?> disabled /> 
        <?php endfor ?>
      </form>
      <p><?php echo strip_tags($plugin['summary']) ?></p>
    </div>
<?php endfor ?>
  </div>
<?php endif ?>

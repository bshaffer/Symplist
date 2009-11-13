<?php if (count($results) == 0): ?>
  No Results
<?php endif ?>
<?php for ($i = 0; $i < count($results); $i++): ?>
  <?php if ($i % 4 == 0): ?>
    <?php if ($i != 0): ?>
  </div>
    <?php endif ?>
  <div class='result-block grid_12 alpha omega'>
  <?php endif ?>
    <div class='featured grid_3 <?php echo $classes[$i%4] ?>'>
      <?php include_partial('plugin/verbose_autocomplete_result', array('plugin' => $results[$i])) ?>
    </div>
<?php endfor ?>
  </div>
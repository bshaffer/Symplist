<?php if (count($results) == 0): ?>
  No Results
<?php endif ?>
<?php foreach ($results as $result): ?>
  <?php $block = get_partial('plugin/verbose_autocomplete_result', array('plugin' => $result)) ?>
  <?php echo str_replace("\n", '', $block)."\n" ?>
<?php endforeach ?>
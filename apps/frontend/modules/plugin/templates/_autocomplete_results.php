<?php if (count($results) == 0): ?>
  No Results
<?php endif ?>
<?php foreach ($results as $result): ?>
<?php echo $result['title']."\n" ?>
<?php endforeach ?>
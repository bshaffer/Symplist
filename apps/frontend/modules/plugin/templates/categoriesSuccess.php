<h1>Plugin Categories</h1>
<ul id='categories-list' class='object-list'>
<?php foreach ($categories as $cat): ?>
  <li>
    <?php echo link_to($cat->getName(), $cat->getRoute()) ?>
    <?php if ($desc = $cat->getDescription()): ?>
      <p><?php echo $desc ?></p>
    <?php endif ?>
  </li>
<?php endforeach ?>
</ul>
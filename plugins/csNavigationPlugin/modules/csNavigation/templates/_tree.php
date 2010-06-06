<?php if (isset($title) && $title): ?>
  <b><?php echo $title ?></b>
<?php endif ?>
<?php if (count($items) > 0): ?>
<ul <?php echo isset($class) ? "class='$class'" : '' ?> <?php echo isset($id) ? "id='$id'" : '' ?>>
<?php foreach ($items as $item): ?>
<?php if ($item->isAuthenticated()): ?>
   <?php if ($item->isActive(get_slot('active-navigation'))): ?>
     <li class="active"><a href="#"><?php echo $item->getName() ?></a>
   <?php elseif ($item->isActiveBranch()): ?>
     <li class="active-parent"><?php echo link_to($item->getName(), $item->getRoute()) ?></a>
   <?php elseif($item->getRoute()): ?>
     <li><?php echo link_to($item->getName(), $item->getRoute()) ?>
   <?php else: ?>
     <li><?php echo $item->getName() ?>
  <?php endif ?>
  <?php if ($item->hasChildren() && ($item->isActiveBranch() || ($max_level && $item->level <= $max_level))): ?>
      <?php include_component('csNavigation', 'tree', array('items' => $item->getChildren(), 'iterations' => $iterations)) ?>
  <?php endif ?>
  </li>
<?php endif; ?> 
<?php endforeach ?>
</ul>
<?php endif ?>
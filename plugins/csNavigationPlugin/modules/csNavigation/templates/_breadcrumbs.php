<?php use_helper('I18N') ?>
<?php if (isset($items) && count($items) > 0): ?>
<ul <?php echo isset($class) ? "class='$class'" : '' ?>>
<?php $i = 1 ?>
<?php foreach ($items as $item): ?>
  <?php if ($item->getRoute() && (count($items) != $i) && !$item->isActive()): ?>
    <li><?php echo link_to(__($item->getName()), $item->getRoute()) ?></li>
  <?php else: ?>
    <li class="last"><?php echo __($item->getName()) ?></li>
  <?php endif ?>
<?php $i++ ?>
<?php endforeach ?>
</ul>
<?php endif ?>
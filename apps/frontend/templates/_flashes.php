<?php if ($sf_user->hasFlash('notice')): ?>
  <span class='flash notice'><?php echo $sf_user->getFlash('notice') ?></span>
<?php endif ?>

<?php if ($sf_user->hasFlash('error')): ?>
  <span class='flash error'><?php echo $sf_user->getFlash('error') ?></span>
<?php endif ?>

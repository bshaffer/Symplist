<?php if ($sf_user->hasFlash('notice')): ?>
  <span class='message info'><?php echo $sf_user->getFlash('notice') ?></span>
<?php endif ?>

<?php if ($sf_user->hasFlash('error')): ?>
  <span class='message important'><?php echo $sf_user->getFlash('error') ?></span>
<?php endif ?>

<?php $attributes = array('background-position:0px -16px',
                          'display:block',
                          'float:left',
                          'width:15px', 
                          'height:15px', 
                          'background-image:url('.image_path('star', array('absolute' => true)).')') ?>
<div class='plugin-rating'>
<?php for($i = 1; $i <= 5; $i++): ?>
  <?php if ($rating < $i): ?>
    <?php $attributes[0] = 'background-position:0px 0px' ?>
  <?php endif ?>
  <div style='<?php echo implode(';', $attributes) ?>'></div>
<?php endfor ?>
</div>
<?php $attributes = array('background-position-y:-16px',
                          'display:block',
                          'float:left',
                          'width:15px', 
                          'height:15px', 
                          'background-image:url('.image_path('star', array('absolute' => true)).')',
                          'background-position-x:0px') ?>
<?php for($i = 1; $i <= 5; $i++): ?>
  <?php if ($rating < $i): ?>
    <?php $attributes[0] = 'background-position-y:0px' ?>
  <?php endif ?>
  <div style='<?php echo implode(';', $attributes) ?>'></div>
<?php endfor ?>
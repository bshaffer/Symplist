<?php use_helper('Form', 'jQuery') ?>

<?php echo form_tag('@list_create') ?>
  <?php echo $form ?>
  <div id='list-items'>
    <?php foreach ($item_forms as $item_form): ?>
      <?php echo $item_form ?>
    <?php endforeach ?>
  </div>
  <?php echo jq_link_to_remote('Add List Item', array(
                'update' => 'list-items', 
                'url' => 'list_item_add_ajax',
                'position' => 'bottom',
    )) ?>
  <?php echo submit_tag('Save', array('class' => 'button')) ?>
</form>


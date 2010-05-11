<?php use_helper('jQuery', 'Markdown') ?>

<?php echo $form->renderFormTag(url_for('@list_create')) ?>
  <?php echo $form ?>
  <div id='list-items'>
    <?php foreach ($item_forms as $item_form): ?>
      <?php echo $item_form ?>
    <?php endforeach ?>
  </div>

  <input type="submit" class="button" value="Add"></input>
  
  <?php echo markdown_preview_link('community_list[description]') ?>    

  <?php echo jq_link_to_remote('Add List Item', array(
                'update' => 'list-items', 
                'url' => 'list_item_add_ajax',
                'position' => 'bottom',
    )) ?>
</form>

<?php echo markdown_preview() ?>
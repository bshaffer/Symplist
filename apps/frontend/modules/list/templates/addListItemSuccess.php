<?php use_helper('Form', 'Markdown') ?>
<h2><?php echo link_to($list['title'], '@community_list?slug='.$list['slug']) ?> - Add Item</h2>

<?php echo form_tag('@community_list_add_item?slug='.$list['slug']) ?>
  <table>
    <?php echo $form ?>
  </table>    
  <?php echo markdown_preview_link('community_list_item[body]') ?>
  <?php echo submit_tag('Add', array('class' => 'button')) ?>
</form>

<?php echo markdown_preview() ?>
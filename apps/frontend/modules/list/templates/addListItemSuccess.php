<?php use_helper('Form') ?>
<h2><?php echo link_to($list['title'], '@community_list?slug='.$list['slug']) ?> - Add Item</h2>

<?php echo form_tag('@community_list_add_item?slug='.$list['slug']) ?>
  <?php echo $form ?>
<?php echo submit_tag('Add') ?>
</form>
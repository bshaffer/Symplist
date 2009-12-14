<?php use_helper('Form', 'Markdown') ?>

<h2><?php echo $list['title'] ?></h2>

<?php echo form_tag('@community_list_edit'.$list['slug']) ?>
  <table>
    <?php echo $form ?>
  </table>
  <?php echo submit_tag('Save') ?>
  <?php echo markdown_preview_tag('community_list[description]') ?>
</form>

<?php if ($sf_user->isAuthenticated()): ?>
  <?php echo link_to('Add an item to this list', 'community_list_add_item', array('slug' => $list['slug'])) ?>
<?php endif ?>
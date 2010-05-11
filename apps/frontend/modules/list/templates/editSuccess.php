<?php use_helper('Markdown') ?>

<h2><?php echo $list['title'] ?></h2>

<?php echo $form->renderFormTag(url_for('@community_list_edit'.$list['slug'])) ?>
  <table>
    <?php echo $form ?>
  </table>

  <input type="submit" value="Save"></input>

  <?php echo markdown_preview_link('community_list[description]') ?>
</form>

<?php echo markdown_preview() ?>

<?php if ($sf_user->isAuthenticated()): ?>
  <?php echo link_to('Add an item to this list', 'community_list_add_item', array('slug' => $list['slug'])) ?>
<?php endif ?>
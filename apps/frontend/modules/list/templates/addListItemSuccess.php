<?php use_helper('Markdown') ?>
<h2><?php echo link_to($list['title'], '@community_list?slug='.$list['slug']) ?> - Add Item</h2>

<?php echo $form->renderFormTag(url_for('@community_list_add_item?slug='.$list['slug'])) ?>
  <table>
    <?php echo $form ?>
  </table>    
  <?php echo markdown_preview_link('community_list_item[body]') ?>

  <input type="submit" class="button" value="Add"></input>
</form>

<?php echo markdown_preview() ?>
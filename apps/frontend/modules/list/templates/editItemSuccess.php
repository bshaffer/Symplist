<?php use_helper('Form', 'Markdown') ?>

<h2><?php echo $item['List']['title'] ?> - Edit Item</h2>

<?php echo form_tag('@community_list_item_edit?slug='.$item['List']['slug'].'&id='.$item['id']) ?>
<?php //echo form_tag('csMarkdown/preview', array('target' => '_blank')) ?>
  <table>
    <?php echo $form ?>
  </table>
  <?php echo submit_tag('Save') ?>
  <?php echo markdown_preview_tag('community_list_item[body]') ?>
  <?php echo link_to('Cancel', '@community_list?slug='.$item['List']['slug']) ?>
</form>


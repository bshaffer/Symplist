<?php use_helper('Form') ?>

<h2><?php echo $item['List']['title'] ?> - Edit Item</h2>

<?php echo form_tag('@community_list_item_edit?slug='.$item['List']['slug'].'&id='.$item['id']) ?>
  <table>
    <?php echo $form ?>
  </table>
  <?php echo submit_tag('Save') ?>
</form>
<?php use_helper('Form') ?>
<?php echo form_tag('sfLucene/search') ?>
<div class='form_query'>
  <?php echo $form['query'] ?>
</div>
<?php echo submit_tag('Search') ?>
</form>
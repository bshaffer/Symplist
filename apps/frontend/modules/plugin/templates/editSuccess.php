<?php use_helper('Form') ?>
<h2>Editing <?php echo $plugin['title'] ?></h2>
<?php echo form_tag('@plugin_edit?title='.$plugin['title']) ?>
  <?php echo $form ?>
  <?php echo submit_tag('Submit') ?>
  <?php echo submit_tag('Back', array('onclick' => 'window.location = "'.url_for('@plugin?title='.$plugin['title']).'";return false;')) ?>  
</form>
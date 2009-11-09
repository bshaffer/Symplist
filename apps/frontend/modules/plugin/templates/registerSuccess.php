<h2>Register a Plugin</h2>

<?php use_helper('Form') ?>
<?php echo form_tag('@plugin_register') ?>
  <?php echo $form ?>
  <?php echo submit_tag('Submit') ?>
</form>
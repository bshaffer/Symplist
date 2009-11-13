<h2>Step 1: Create your Developer Login</h2>

<?php use_helper('Form') ?>
<?php echo form_tag('@author_new') ?>
  <table>
    <?php echo $form ?>
  </table>
  <?php echo submit_tag('Submit') ?>
</form>
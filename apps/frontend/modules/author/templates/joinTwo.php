<h2>Step 2: Fill our your Profile</h2>

<?php use_helper('Form') ?>
<?php echo form_tag('@author_new') ?>
  <table>
    <?php echo $form ?>
  </table>
  <?php echo submit_tag('Submit', array('class' => 'button')) ?>
</form>
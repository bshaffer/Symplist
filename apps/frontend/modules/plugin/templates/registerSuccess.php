<h2>Register a Plugin</h2>

<?php echo $form->renderFormTag(url_for('@plugin_register')) ?>
  <table>
    <?php echo $form ?>
  </table>
  <input type="submit" value="Submit"></input>
</form>
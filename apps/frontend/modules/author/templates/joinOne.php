<h2>Step 1: Create your Developer Login</h2>

<?php use_helper('Form') ?>
<?php echo $form->renderFormTag(url_for('@author_new')) ?>
  <table>
    <?php echo $form ?>
  </table>
  
  <input type="submit" class="button" value="Submit"></input>
</form>
<h2>Step 2: Fill our your Profile</h2>

<?php use_helper('Form') ?>
<?php echo $form->renderFormTag(url_for('@author_new')) ?>
  <table>
    <?php echo $form ?>
  </table>

  <input type="submit" class="button" value="Submit"></input>
</form>
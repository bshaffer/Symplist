<?php use_helper('Form', 'Attachments') ?>
<h2>Editing <?php echo $plugin['title'] ?></h2>
<?php echo form_tag('@plugin_edit?title='.$plugin['title']) ?>
    <?php echo $form->renderHiddenFields() ?>
    <?php echo $form->renderGlobalErrors() ?>    
  <table>
    <?php echo $form['title']->renderRow() ?>
    <?php echo $form['description']->renderRow() ?>
    <?php echo $form['category_id']->renderRow() ?>
    <?php echo $form['repository']->renderRow() ?>
    <?php echo $form['image']->renderRow() ?>
    <?php echo $form['homepage']->renderRow() ?>
  </table>
  <?php echo submit_tag('Submit', array('class' => 'button')) ?>
  <?php echo submit_tag('Back', array('class' => 'button', 'onclick' => 'window.location = "'.url_for('@plugin?title='.$plugin['title']).'";return false;')) ?>  
</form>

<?php echo jq_attachments_admin(new SymfonyPluginForm($plugin)) ?>
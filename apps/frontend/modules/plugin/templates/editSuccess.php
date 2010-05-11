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

  <input type="submit" value="Submit" class="button"></input>
  <input type="submit" value="Back" class="button" onclick="window.location = '<?php echo url_for('@plugin?title='.$plugin['title']) ?>';return false;"></input>
</form>

<?php echo jq_attachments_admin(new SymfonyPluginForm($plugin)) ?>
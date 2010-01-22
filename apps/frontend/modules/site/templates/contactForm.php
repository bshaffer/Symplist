<?php slot('title', 'Contact sympLIST') ?>
<h2>Contact sympLIST</h2>

<p>Questions? Hate-Mail? We appreciate any contact with the outside world, regardless of motive.</p>

<?php use_helper('Form') ?>
<?php echo form_tag('@contact', array('class' => 'contact-form')) ?>
<table>
  <?php echo $form ?>
</table>
<?php echo submit_tag('Send', array('class' => 'button')) ?>
</form>
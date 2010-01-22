<?php use_helper('Form') ?>
<h2>Are you sure you want to register <?php echo $plugin['title'] ?>?</h2>
<?php slot('title', 'Claim Plugin') ?>

<em>Please only register plugins you are the lead developer of.  Be considerate!</em>
<?php echo form_tag('@plugin_claim?title='.$plugin['title']) ?>
<?php echo submit_tag('Register') ?>
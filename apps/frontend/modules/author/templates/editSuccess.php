<?php use_helper('Form') ?>

<?php echo form_tag('@author_edit?username='.$user['username'], array('class' => 'edit_user_form')) ?>
<h3>User Information</h3>
<table>
<?php echo $userform ?>
</table>

<h3>Profile Information</h3>
<table>
<?php echo $profileform ?>
</table>

<?php echo submit_tag('Save') ?>
<?php echo link_to('Cancel', '@author?username='.$user['username']) ?>
</form>
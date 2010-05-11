<?php echo $userform->formTagFor(url_for('@author_edit?username='.$user['username']), array('class' => 'edit_user_form')) ?>
<h3>User Information</h3>
<table>
<?php echo $userform ?>
</table>

<h3>Profile Information</h3>
<table>
<?php echo $profileform ?>
</table>

<input type="submit" value="Save"></input>

<?php echo link_to('Cancel', '@author?username='.$user['username']) ?>
</form>
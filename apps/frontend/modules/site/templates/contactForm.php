<?php slot('title', 'Contact sympLIST') ?>
<h2>Contact sympLIST</h2>

<p>Questions? Hate-Mail? We appreciate any contact with the outside world, regardless of motive.</p>

<?php echo $form->renderFormTag(url_for('@contact'), array('class' => 'contact-form')) ?>
<table>
  <?php echo $form ?>
</table>
<input type="submit" class="button" value="Send"></input>
</form>
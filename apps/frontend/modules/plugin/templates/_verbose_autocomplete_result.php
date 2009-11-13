<h6><?php echo link_to($plugin['title'], '@plugin?title='.$plugin['title'], array('class' => 'plugin-title')) ?></h6>
<form class="rating">
  <?php for($i = 1; $i <= 5; $i++): ?>
  <input name="star1" type="radio" class="star" <?php echo ($plugin['rating'] == $i)?'checked':'' ?> disabled /> 
  <?php endfor ?>
</form>
<p><?php echo strip_tags($plugin['summary']) ?></p>

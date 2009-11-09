<h6><?php echo link_to($plugin['title'], '@plugin?title='.$plugin['title']) ?></h6>
<form class="rating">
  <input name="star1" type="radio" class="star" /> 
  <input name="star1" type="radio" class="star" /> 
  <input name="star1" type="radio" class="star" /> 
  <input name="star1" type="radio" class="star" checked /> 
  <input name="star1" type="radio" class="star" />
</form>
<p><?php echo strip_tags($plugin['description']) ?></p>
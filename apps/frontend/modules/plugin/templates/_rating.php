<form class="rating">
<?php for($i = 1; $i <= 5; $i++): ?>
  <input name="star1" type="radio" class="star" <?php echo ($rating == $i)?'checked':'' ?> disabled /> 
<?php endfor ?>
</form>
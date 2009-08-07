<h1>We're Sorry. This page is not found.</h1>
<p>
	The page you are looking for cannot be found. Please use the navigation above, or 
	<?php echo link_to('click here', '@homepage') ?>
	to go to the homepage.
</p>
<?php if ($results->count()): ?>
	<br />
	<div class="searchresults">
	  <h2>Could you possibly have meant one of these pages?</h2>		
	</div>
	<ol class='search_container'>
		<?php foreach ($results as $result): ?>
			<li> 	
				<h6>
					<?php echo link_to($result['title'], $result['url']) ?>
				</h6>
				<p>
					<?php echo $result['description'] ?>
				</p>
			</li>
		<?php endforeach ?>	
	</ol>
<?php endif; ?>
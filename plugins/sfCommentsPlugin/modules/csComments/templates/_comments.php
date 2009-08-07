<?php if( $comments && $record ): ?>
  <a name="comments"></a>
  <ul>
		<?php foreach($comments AS $comment): ?>
		  <?php if ($comment->isApproved()): ?>		    
  		 <?php include_partial('csComments/comment_row', array('comment' => $comment, 'record' => $record)) ?>
		  <?php endif ?>
		<?php endforeach ?>
	</ul>
<?php endif;?>
    
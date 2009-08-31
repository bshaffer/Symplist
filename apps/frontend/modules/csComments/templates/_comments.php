<?php if( $comments && $record ): ?>
	<?php foreach($comments AS $comment): ?>
	  <?php if ($comment->isApproved()): ?>		    
		 <?php include_partial('csComments/comment_row', array('comment' => $comment, 'record' => $record)) ?>
	  <?php endif ?>
	<?php endforeach ?>
<?php endif;?>
    
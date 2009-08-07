<?php if ($comment->isApproved()): ?>
  <?php include_partial('csComments/comment_row', array('comment' => $comment, 'record' => $record)) ?>
<?php else: ?>
  <span>
    Thank you for submitting your form.  Your comment is pending approval.
  </span>  
<?php endif ?>
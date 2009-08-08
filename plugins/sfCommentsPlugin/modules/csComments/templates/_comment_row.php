<?php use_helper('Date'); ?>

<li class="comment_row">
  <a name="comment_<?php echo $comment->getId(); ?>"></a>
  
  <div id="comment_content">
    <div id="author_and_date">
		<?php $poster = $comment->hasCommenter() ? $comment->getCommenter() : 'Anonymous' ?>
		<?php $posted_by = $comment['Commenter']['website'] ? link_to($poster, $comment['Commenter']['website']) : $poster ?>
      posted by <?php echo $posted_by ?> <?php echo distance_of_time_in_words(strtotime($comment->getCreatedAt())); ?> ago.
    </div>
  
    <div id="body">
      <?php echo nl2br($comment->getBody()); ?>
    </div>
  
    <?php if (sfConfig::get('app_comments_nesting')): ?>
      <div id="links">
        <?php echo link_to_add_new_comment('Reply', $record, $comment); ?>
      </div>      
    <?php endif ?>

    <div id="add_new_comment_form_holder_<?php echo $comment->getId(); ?>"></div>
    
    <?php if ($comment->getNode()->hasChildren()): ?>
      <?php echo get_partial('csComments/comments', array('comments' => $comment->getNode()->getChildren(), 'record' => $record)); ?>
    <?php endif ?>
  </div>
</li>

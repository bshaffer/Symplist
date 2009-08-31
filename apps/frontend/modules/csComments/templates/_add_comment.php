<?php use_helper('Form') ?>
<div id='add-comment-form'>
  <h3>Add New Comment</h3>
  <?php use_helper('Javascript') ?>
  <?php echo form_remote_tag( 
                  array('url'       => '@cscomments_comments_do_add',
                        'update'    => 'add-comment-form',
                        'enctype'   => 'multipart/form-data',
                        'loading'   => "Element.show('indicator'); Element.hide('btn_submit')",
                        'complete'  => "Element.hide('indicator'); Element.show('btn_submit');"
    )) ?>

    <?php echo input_hidden_tag('return_uri', $sf_request->getParameter('return_uri')); ?>
    <?php echo input_hidden_tag('comment_id', $sf_request->getParameter('comment_id')); ?>
    <?php echo input_hidden_tag('model', $sf_request->getParameter('model')); ?>
    <?php echo input_hidden_tag('record_id', $sf_request->getParameter('record_id')); ?>
  
    <?php if(isset($commentForm)): ?>
        <?php echo $commentForm['Commenter'] ?>
        <?php //echo $commentForm['rating'] ?>
        <?php echo $commentForm['body'] ?>
    <?php endif ?>  
  

    <?php echo submit_tag('Add', array('class' => 'button')); ?>
  
    <span id='indicator' style='display:none'>Loading...</span>
  </div>
</li>

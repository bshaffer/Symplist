<?php use_helper('Form') ?>
<div id='add-comment-form'>
  <h3>Add New Comment</h3>
  <?php use_helper('jQuery') ?>
  <?php echo jq_form_remote_tag( 
                  array('url'       => '@cscomments_comments_do_add',
                        'update'    => 'add-comment-form',
                        'enctype'   => 'multipart/form-data',
                        'loading'   => "$('#comment-indicator').show();$('#submit-comment-button').hide();",
                        'complete'  => "$('#comment-indicator').hide();$('#submit-comment-button').show();"
    )) ?>

    <?php echo input_hidden_tag('return_uri', $sf_request->getParameter('return_uri')); ?>
    <?php echo input_hidden_tag('comment_id', $sf_request->getParameter('comment_id')); ?>
    <?php echo input_hidden_tag('model', $sf_request->getParameter('model')); ?>
    <?php echo input_hidden_tag('record_id', $sf_request->getParameter('record_id')); ?>
  
  
    <?php if(isset($commentForm)): ?>
      <?php if ($sf_user->isAuthenticated()): ?>
        <table>
          <tr>
            <th><label for="comment_Commenter_username">Username</label></th>
            <td><em>Signed in as <?php echo $sf_user->getUsername() ?></em></td>
          </tr>
        </table>
      <?php else: ?>
        <?php echo $commentForm['Commenter'] ?>
      <?php endif ?>
      
      <?php echo $commentForm['body'] ?>
    <?php endif ?>    

    <?php echo submit_tag('Add', array('class' => 'button', 'id' => 'submit-comment-button')); ?>
  
    <span id='comment-indicator' style='display:none'>
      <?php echo image_tag('ajax-loader.gif', array('alt' => 'Loading...')) ?>
    </span>
  </div>
</li>

<?php use_helper('I18N', 'Date') ?>
<?php include_partial('csCommentAdmin/assets') ?>

<div id="sf_admin_container" class='clearfix'>
  <h1><?php echo __('New CsCommentAdmin', array(), 'messages') ?></h1>



  <div id="sf_admin_header">
    <?php include_partial('csCommentAdmin/form_header', array('comment' => $comment, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content" class="grid_11 prefix_4">
  	<?php include_partial('csCommentAdmin/flashes') ?>
    <?php include_partial('csCommentAdmin/form', array('comment' => $comment, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('csCommentAdmin/form_footer', array('comment' => $comment, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>
</div>

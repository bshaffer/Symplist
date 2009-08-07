<?php use_helper('I18N', 'Date') ?>
<?php include_partial('csCommentAdmin/assets') ?>

<div id="sf_admin_container" class="clearfix">
	<?php include_partial('csCommentAdmin/flashes') ?>
	
  <h1 class="admin-title"><?php echo __('CsCommentAdmin List', array(), 'messages') ?></h1>

  <div id="sf_admin_header">
    <?php include_partial('csCommentAdmin/list_header', array('pager' => $pager)) ?>
  </div>
  
  <div id="sf_sidebar-right" class="grid_4">

  </div>
      <div id="sf_admin_bar" class="grid_11 alpha">
      <?php include_partial('csCommentAdmin/filters', array('form' => $filters, 'configuration' => $configuration)) ?>
    </div>
    <div id="sf_admin_content" class="grid_11 prefix_4">
		<div id='sf_admin_actions_container'>
    <form action="<?php echo url_for('comment_csCommentAdmin_collection', array('action' => 'batch')) ?>" method="post">
	    <?php include_partial('csCommentAdmin/list_batch_actions', array('helper' => $helper)) ?>
	    <ul class="sf_admin_actions">
	      <?php include_partial('csCommentAdmin/list_actions', array('helper' => $helper)) ?>
	    </ul>
		</div>

    <?php include_partial('csCommentAdmin/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?>
    </form>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('csCommentAdmin/list_footer', array('pager' => $pager)) ?>
  </div>
</div>

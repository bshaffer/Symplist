[?php use_helper('I18N', 'Date') ?]
[?php include_partial('<?php echo $this->getModuleName() ?>/assets') ?]

<div id="sf_admin_container" class="clearfix">
	[?php include_partial('<?php echo $this->getModuleName() ?>/flashes') ?]
	
  <h1 class="admin-title">[?php echo <?php echo $this->getI18NString('list.title') ?> ?]</h1>

  <div id="sf_admin_header">
    [?php include_partial('<?php echo $this->getModuleName() ?>/list_header', array('pager' => $pager)) ?]
  </div>
  
  <div id="sf_sidebar-right" class="grid_4">

  </div>
  <?php if ($this->configuration->hasFilterForm()): ?>
    <div id="sf_admin_bar" class="grid_11 alpha">
      [?php include_partial('<?php echo $this->getModuleName() ?>/filters', array('form' => $filters, 'configuration' => $configuration)) ?]
    </div>
  <?php endif; ?>
  <div id="sf_admin_content" class="grid_11 prefix_4">
		<div id='sf_admin_actions_container'>
<?php if ($this->configuration->getValue('list.batch_actions')): ?>
    <form action="[?php echo url_for('<?php echo $this->getUrlForAction('collection') ?>', array('action' => 'batch')) ?]" method="post">
	    [?php include_partial('<?php echo $this->getModuleName() ?>/list_batch_actions', array('helper' => $helper)) ?]
<?php endif; ?>
	    <ul class="sf_admin_actions">
	      [?php include_partial('<?php echo $this->getModuleName() ?>/list_actions', array('helper' => $helper)) ?]
	    </ul>
		</div>

    [?php include_partial('<?php echo $this->getModuleName() ?>/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?]
<?php if ($this->configuration->getValue('list.batch_actions')): ?>
    </form>
<?php endif; ?>
  </div>

  <div id="sf_admin_footer">
    [?php include_partial('<?php echo $this->getModuleName() ?>/list_footer', array('pager' => $pager)) ?]
  </div>
</div>

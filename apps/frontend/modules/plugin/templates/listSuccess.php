<?php use_helper('Pager') ?>
<h2>Plugins</h2>
<span class='view-all-plugins'><?php echo link_to('View All', '@plugins_view_all') ?></span>
<?php $results = $pager->getResults()?>
<?php //echo get_pager_controls($pager) ?>
<ol start='<?php echo $pager->getFirstIndice() ?>' class='plugins-list'>
<?php foreach ($results as $plugin): ?>
  <li>
    <?php include_partial('plugin/plugin', array('plugin' => $plugin)) ?>
  </li>
<?php endforeach ?>
</ol>
<?php echo get_pager_controls($pager) ?>
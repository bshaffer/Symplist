<?php use_helper('Pager') ?>
<h1>Plugins <span class='view-all-plugins'><?php echo link_to('View All', '@plugins_view_all') ?></span></h1>
<?php $results = $pager->getResults()?>
<?php //echo get_pager_controls($pager) ?>
<ul start='<?php echo $pager->getFirstIndice() ?>' class='plugins-list'>
<?php foreach ($results as $plugin): ?>
  <li>
    <?php include_partial('plugin/list_item', array('plugin' => $plugin)) ?>
  </li>
<?php endforeach ?>
</ul>
<?php echo get_pager_controls($pager) ?>
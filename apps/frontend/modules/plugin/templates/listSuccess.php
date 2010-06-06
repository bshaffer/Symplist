<?php use_helper('Pager') ?>
<?php slot('title', 'All Plugins') ?>
<h2>Plugins</h2>


<ul class="secondary-nav">
  <li class="view-all-plugins">
    <?php echo link_to('View All', '@plugins_view_all') ?>
  </li>

  <li class="register-plugin">
    <?php echo link_to('Register a Plugin', '@plugin_register') ?>
  </li>

</ul>

<?php $results = $pager->getResults()?>
<ol start='<?php echo $pager->getFirstIndice() ?>' class="plugins-list">
<?php foreach ($results as $plugin): ?>
  <li>
    <?php include_partial('plugin/plugin', array('plugin' => $plugin)) ?>
  </li>
<?php endforeach ?>
</ol>
<?php echo get_pager_controls($pager) ?>
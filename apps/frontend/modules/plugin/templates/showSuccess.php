<?php use_helper('Comment') ?>

<h2><?php echo $plugin['title'] ?></h2>

<p><?php echo $plugin['description'] ?></p>

<?php if ($sf_user->isAuthenticated() && $sf_user->getGuardUser()->id == $plugin->user_id): ?>
  <?php echo link_to('[edit]', '@plugin_edit?title='.$plugin['title']) ?>
<?php endif ?>

<div class='plugin-info <?php echo $plugin['title'] ?>'>
  <dl>
    
    <dt>Repository</dt>
    <dd><?php echo link_to($plugin->getRepository(), $plugin->getRepository(), array('style' => 'white-space:nowrap;')) ?></dd>

    <dt>More Info</dt>
    <dd><?php echo link_to($plugin->getHomepage(), $plugin->getHomepage(), array('style' => 'white-space:nowrap;')) ?></dd>


    <dt>Last Updated</dt>
    <dd><?php echo date('F jS, Y', strtotime($plugin->getUpdatedAt())) ?></dd>
  
    <dt>Releases</dt>
    <dd>
      <?php if ($plugin['Releases']->count()): ?>
        <?php foreach ($plugin['Releases'] as $release): ?>
          <?php echo $release['version'] ?>&nbsp;&nbsp;&nbsp;
        <?php endforeach ?>
      <?php else: ?>
        None
      <?php endif ?>
    </dd>

    <dt>Rate this Plugin</dt>
    <dd>
      <?php include_partial('plugin/rating_info', array('plugin' => $plugin)) ?>
      <?php include_partial('plugin/rate_javascript', array('plugin' => $plugin)) ?>
    </dd>

<?php if ($plugin->isRegistered()): ?>
    <dt>Owner</dt>
    <dd><?php echo link_to($plugin['User']->getUsername(), $plugin['User']->getRoute(), array('class' => 'author-link')) ?></dd>
  </dl>
<?php else: ?>
  </dl>

  <?php echo link_to('Claim This Plugin', '@plugin_claim?title='.$plugin['title'], array('class' => 'button')) ?>
<?php endif ?>


</div>

<?php echo get_comments($plugin) ?>
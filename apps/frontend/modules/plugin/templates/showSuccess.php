<?php use_helper('Comment') ?>

<h1><?php echo $plugin['title'] ?></h1>
<p>
  <?php echo $plugin['description'] ?>
</p>

<table id='plugin-info'>
  <tr>
    <th>Rating</th>
    <td>
      <span class='rating'><?php include_component('plugin', 'rating', array('rating' => $plugin->getRating())) ?></span>
      <span class='num_votes'>(<?php echo $plugin->getNumVotes() . ($plugin->getNumVotes() == 1 ? ' vote' : ' votes') ?>)</span>
    </td>
  </tr>
  <tr>
    <th>Repository</th>
    <td><?php echo link_to($plugin->getRepository(), $plugin->getRepository(), array('style' => 'white-space:nowrap;')) ?></td>
  </tr>
  <tr>
    
  <tr>
    <th>More Info</th>
    <td><?php echo link_to($plugin->getSymfonyPluginsUrl(), $plugin->getSymfonyPluginsUrl(), array('style' => 'white-space:nowrap;')) ?></td>
  </tr>
  
  <tr>
    <th>Last Updated</th>
    <td><?php echo date('F jS, Y', strtotime($plugin->getUpdatedAt())) ?></td>
  </tr>  
  
<?php if ($plugin->isRegistered()): ?>
    <th>Owner</th>
    <td class='plugin-author'>
      <?php echo link_to($plugin['User']->getUsername(), $plugin['User']->getRoute(), array('class' => 'author-link')) ?>
    </td>
<?php else: ?>
    <td colspan='2' class='claim'>
      <?php echo link_to('Claim This Plugin', '@plugin_claim?title='.$plugin['title']) ?>
    </td>
<?php endif ?>
  </tr>
</table>

<?php echo get_comments($plugin) ?>
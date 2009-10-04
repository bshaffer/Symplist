<ul class='list community-list'>
<?php foreach ($lists as $list): ?>
<li>
  <h3><?php echo link_to($list['title'], 'community_list', array('slug' => $list['slug'])) ?></h3>
  <p>
    <?php echo strip_tags($list['description']) ?>
  </p>
</li>
<?php endforeach ?>
</ul>
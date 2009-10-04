<?php use_helper('Pager') ?>
<h1>Community Lists</h1>
<ul class='list community-list'>
<?php foreach ($lists as $list): ?>
<li>
  <h3><?php echo link_to($list['title'], 'community_list', array('slug' => $list['slug'])) ?></h3>
  <p>
    <?php echo strip_tags($list['description_html']) ?>
  </p>
</li>
<?php endforeach ?>
</ul>
<?php echo get_pager_controls($pager) ?>
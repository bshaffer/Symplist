<?php use_helper('Pager') ?>
<h2>Community Lists</h2>

<p><?php echo link_to('Create a list', '@list_create') ?></p>

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
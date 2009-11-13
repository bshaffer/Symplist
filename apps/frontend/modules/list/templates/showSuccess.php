<h2><?php echo $list['title'] ?></h2>

<?php if ($list['submitted_by']): ?>
  <p><span class='list-submitted-by'>Submitted By <?php echo link_to($list['User']['username'], '@author?username='.$list['User']['username']) ?></span>  </p>
<?php endif ?>

<?php echo $list['description_html'] ?>
<ol class='community-list-items'>
<?php foreach ($list->getOrderedItems() as $item): ?>
  <li class='list-item-<?php echo $item['id'] ?>'>
    <div class='list-item-header slide-open-link'>
      <span class='list-item-title'><?php echo $item['title'] ?></span>
      <span class='thumbs_rating'>
        <?php include_partial('list/rating', array('item' => $item)) ?>
      </span>

      <span class='list-item-submitted-by'>Submitted By <?php echo link_to($item['User']['username'], '@author?username='.$item['User']['username']) ?></span>  

      <?php echo $item['body_html'] ?>
    </div>      
  </li>
<?php endforeach ?>
</ol>

<?php if ($sf_user->isAuthenticated()): ?>
  <?php echo link_to('Add an item to this list', 'community_list_add_item', array('slug' => $list['slug'])) ?>
<?php endif ?>

<script type='text/javascript'>
  $(document).ready(function(){
    $('.community-list-items li').expander();
  })
</script>
<h1><?php echo $list['title'] ?></h1>
<?php if ($list['submitted_by']): ?>
  <span class='list-submitted-by'>Submitted By <?php echo link_to($list['User']['username'], '@author?username='.$this['User']['username']) ?></span>  
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
    </div>
    <div class='list-item-<?php echo $item['id'] ?>-rating-info'>
      <span class='messages'></span>    
      <?php include_partial('list/rate.js', array('item' => $item)) ?>
    </div>  

    <div class='slide-container'>
      <span class='list-item-submitted-by'>Submitted By <?php echo link_to($item['User']['username'], '@author?username='.$item['User']['username']) ?></span>  

      <?php echo $item['body_html'] ?>
    </div>      
  </li>
<?php endforeach ?>
</ol>

<?php if ($sf_user->isAuthenticated()): ?>
  <?php echo link_to('Add an item to this list', 'community_list_add_item', array('slug' => $list['slug'])) ?>
<?php endif ?>
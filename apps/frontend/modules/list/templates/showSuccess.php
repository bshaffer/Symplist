<h1><?php echo $list['title'] ?></h1>

<?php echo $list['description_html'] ?>
<ol class='community-list-items'>
<?php foreach ($list->getOrderedItems() as $item): ?>
  <li class='list-item-<?php echo $item['id'] ?>'>
    <h3>
      <?php echo $item['title'] ?>
      <span class='thumbs_rating'>
        <?php include_partial('list/rating', array('item' => $item)) ?>
      </span>
    </h3>
    <span class='messages'></span>    
    <?php echo $item['body_html'] ?>
    
    <div class='list-item-<?php echo $item['id'] ?>-rating-info'>
      <?php include_partial('list/rate.js', array('item' => $item)) ?>
    </div>  
  </li>
<?php endforeach ?>
</ol>
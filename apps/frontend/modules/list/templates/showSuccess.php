<h1><?php echo $list['title'] ?></h1>

<?php echo $list['description_html'] ?>

<ol class='community-list-items'>
<?php foreach ($list->getOrderedItems() as $item): ?>
  <li>
    <h3><?php echo $item['title'] ?><?php include_partial('list/rating', array('item' => $item)) ?></h3>
    <?php echo $item['body_html'] ?>
  </li>
<?php endforeach ?>
</ol>
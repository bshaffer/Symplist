<?php $sf_user->setFlash('full-page', true) ?>
<?php slot('active-navigation', 'Lists') ?>

<h2><?php echo $list['title'] ?></h2>

<?php if ($list['submitted_by']): ?>
  <p><span class='list-submitted-by'>Submitted By <?php echo link_to($list['User']['username'], '@author?username='.$list['User']['username']) ?></span>  </p>
<?php endif ?>

<?php echo $list['description_html'] ?>
<ol class='community-list-items'>
<?php foreach ($list->getOrderedItems() as $item): ?>
  <li class='list-item-<?php echo $item['id'] ?>'>
    
    <div class='thumbs' value="<?php echo $item['id'] ?>"><?php include_partial('list/rating', array('item' => $item)) ?></div>

    <div class='list-item-header'>
      <span>
        <?php echo $item['title'] ?>
        <?php if ($item['submitted_by'] == $sf_user->getId()): ?>
            <?php echo link_to('edit', 'community_list_item_edit', array('id' => $item['id'], 'slug' => $list['slug'])) ?>
        <?php endif ?>

      </span>
    </div>


    <?php if ($item['body']): ?>
      <div class='expandable'>
        <span class='submitted-by'>Submitted By <?php echo link_to($item['User']['username'], '@author?username='.$item['User']['username']) ?></span>          
        <div class='expandable-content'>
          <?php echo $item['body_html'] ?>
        </div>
      </div>
    <?php endif ?>
  </li>
<?php endforeach ?>
</ol>

<?php if ($sf_user->isAuthenticated()): ?>
  <?php echo link_to('Add an item to this list', 'community_list_add_item', array('slug' => $list['slug'])) ?>
<?php endif ?>

<script type='text/javascript'>
  $(document).ready(function(){
    $('.expandable').expander({
      slicePoint: 0, 
      expandEffect: 'show', 
      userCollapseText: 'hide',
      expandPrefix: '',
      expandText: '[more]'
    });
    
    $('.thumbs input').click(function(){
      var listid = $(this).parents('.thumbs').attr('value');
      if ($.cookie("list-item-"+listid+".rating")) { 
          $('.community-list-items').before("<div class='message important'>You have already rated this item</div>");
          return false;
        } else {
          $(this).parent().load("<?php echo url_for('@list_rate_ajax?id='.$list['id']) ?>", { id: listid, rating: $(this).attr('value') }, function() { 
            $.cookie("list-item-"+listid+".rating", $(this).parents('.thumbs').attr('value'));
            $('.community-list-items').before("<div class='message info'>Thank you for rating this item</div>");
          });
        }; 
    });
  });
</script>
<script type="text/javascript" charset="utf-8">
  $(document).ready(function(){
    $('.list-item-<?php echo $item["id"] ?> a').click(function(){
      if ($.cookie("list-item-<?php echo $item['id'] ?>.rating")) 
      { 
        $('.list-item-<?php echo $item["id"] ?> .messages').html("You have already rated this item").addClass('notice').show("normal");
        $('.list-item-<?php echo $item["id"] ?> .messages').parent().css('display', 'block');
        return false;
      };
      var rating = $(this).hasClass('thumbs-up') ? 1 : -1;
      $('.list-item-<?php echo $item["id"] ?> .thumbs_rating').load(
          "<?php echo url_for('@list_rate_ajax') ?>", 
          { 'rating': rating, 'id': <?php echo $item['id'] ?>}, 
          function() { 
            $('.list-item-<?php echo $item["id"] ?> .messages').html("Thank you for your input").show("normal").parent().css('display', 'block');
            $.cookie("list-item-<?php echo $item['id'] ?>.rating", rating);
          });
    })
  });
</script>

<script type="text/javascript" charset="utf-8">
  $(document).ready(function(){
    $('.rate_this a').click(function(){
      if ($.cookie("<?php echo $plugin['title'] ?>.rating")) 
      { 
        $('.<?php echo $plugin["title"] ?> .messages').html("You have already rated this plugin").addClass('notice').show("normal");
        $('.<?php echo $plugin["title"] ?> .messages').parent().css('display', 'table-row');
        return false;
      };
      var rating = $(this).html();
      $('#editable-rating').load("<?php echo url_for('@plugin_rate_ajax?title='.$plugin['title']) ?>", { 'rating': rating }, function() { 
            $('.<?php echo $plugin["title"] ?> .messages').html("Thank you for rating this plugin").show("normal").parent().css('display', 'table-row');
            $.cookie("<?php echo $plugin['title'] ?>.rating", rating);
            });
    })
    
    $('.star_rating_editable').hover(
      function() {
        $('.star_rating_editable a.selected').removeClass('selected').addClass('selected-tmp');
      }, 
      function() {
        $('.star_rating_editable a.selected-tmp').removeClass('selected-tmp').addClass('selected');
      });
  });
</script>
<?php $sf_response->addJavascript('jquery.cookie.js') ?>
<script type="text/javascript" charset="utf-8">
  jQuery.noConflict();
  jQuery(document).ready(function(){
    jQuery('.rate_this a').click(function(){
      if (jQuery.cookie("<?php echo $plugin['title'] ?>.rating")) 
      { 
        jQuery('.<?php echo $plugin["title"] ?> .messages').html("You have already rated this plugin").addClass('notice').show("normal");
        jQuery('.<?php echo $plugin["title"] ?> .messages').parent().css('display', 'table-row');
        return false;
      };
      var rating = jQuery(this).html();
      jQuery('#editable-rating').load("<?php echo url_for('@plugin_rate_ajax?title='.$plugin['title']) ?>", { 'rating': rating }, function() { 
            jQuery('.<?php echo $plugin["title"] ?> .messages').html("Thank you for rating this plugin").show("normal").parent().css('display', 'table-row');
            jQuery.cookie("<?php echo $plugin['title'] ?>.rating", rating);
            });
    })
    
    jQuery('.star_rating_editable').hover(
      function() {
        jQuery('.star_rating_editable a.selected').removeClass('selected').addClass('selected-tmp');
      }, 
      function() {
        jQuery('.star_rating_editable a.selected-tmp').removeClass('selected-tmp').addClass('selected');
      });
  });
</script>
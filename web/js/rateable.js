
function setRatingListeners()
{
  jQuery('.rate_this li a').click(function(){ 
    var container = jQuery(this).parent().parent().parent();
    container.find('input').attr('value', this.id);
    container.find('.selected').removeClass('selected');
    jQuery(this).addClass('selected');
    return false; 
  });
}

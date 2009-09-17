
function setRatingListeners()
{
  $('.rate_this li a').click(function(){ 
    var container = $(this).parent().parent().parent();
    container.find('input').attr('value', this.id);
    container.find('.selected').removeClass('selected');
    $(this).addClass('selected');
    return false; 
  });
}

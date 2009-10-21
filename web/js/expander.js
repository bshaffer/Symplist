$(document).ready(function() {
  // Hide divs in JS in case browser has it turned off
  $('.slide-container').css('display', 'none');  
  
	$('.slide-open-link').click(function(){
		$(this).siblings('.slide-container').toggle('fast');
	});
	
	$('.slide-open-link').click(function(){
 		$(this).toggleClass('expanded');
	});
		
   $('.slide-close-link').click(function(){
      $(this).parent('.slide-container').hide('fast');
   });
});
$(document).ready(function() {
    $("form.sf-filter input[type = 'checkbox']").addClass('sf-checkbox');
    $("#sf_admin_bar").css('display', 'none');
		if($(".sf_admin_filter").size() > 0)
		{
    	$("#sf_admin_actions_container").append('<a href="#" id="show" class="filter-actions">Show Filters</a><a href="#" id="hide" class="filter-actions">Hide Filters</a>');			
		}

    $("#hide").css('display', 'none');
    $("#show").click(function() {
        $("#sf_admin_bar").slideDown('slow');
        $('#show').fadeOut('slow', function() {
                $('#hide').fadeIn('slow');
        });
        return false;
    });
    
    $("#hide").click(function() {
        $("#sf_admin_bar").slideUp('slow');
        $('#hide').fadeOut('slow', function() {
                $('#show').fadeIn('slow');
        });
        
        return false;
    });
});
jQuery(document).ready(function($) {
    //hide color picker divs
	$('.colorpicker').hide();
	
	//init color picker for each input
	$('.color-picker .color').each(function() {
		color_input = $(this);
	
		$(this).parent().find('.colorpicker').farbtastic(color_input);
	});
	
	//add click event to display the colorpicker
    $('.color-picker .color').click(function() {
		color_input = $(this);
	
		$(this).parent().find('.colorpicker').farbtastic(color_input).fadeIn();
    });
	
	//hide color picker if clicked outside
	$(document).mousedown(function() {
		$('.colorpicker').each(function() {
			var display = $(this).css('display');
			if ( display == 'block' )
				$(this).fadeOut();
		});
	});
		
	//datepicker	
	$('.datepicker').datepicker({
		dateFormat : 'yy-mm-dd'
	});
});	

/* show/hide slideout (triangle button) */
jQuery('.bonfire-slideout-button, .canvas-text-trigger').click(function(){
	if(jQuery('.bonfire-slideout').hasClass('bonfire-slideout-active'))
	{



		/* hide canvas */
		setTimeout(function(){
			jQuery('.bonfire-slideout').removeClass('bonfire-slideout-active');
		},650);
		jQuery('.bonfire-slideout').removeClass('bonfire-slideout-active-translate');

		return false;
	}
	else
	{



		/* show canvas */
		jQuery('.bonfire-slideout').addClass('bonfire-slideout-active');
		jQuery('.bonfire-slideout').addClass('bonfire-slideout-active-translate');

		return false;
	}
});

/* hide slideout (X button) */
jQuery('.bonfire-slideout-close').click(
	function() {



		/* hide canvas */
		setTimeout(function(){
			jQuery('.bonfire-slideout').removeClass('bonfire-slideout-active');
		},650);
		jQuery('.bonfire-slideout').removeClass('bonfire-slideout-active-translate');

		return false;
});


/* hide slideout (ESC button) */
jQuery(document).keyup(function(e) {
	if (e.keyCode == 27) { 



		/* hide canvas */
		setTimeout(function(){
			jQuery('.bonfire-slideout').removeClass('bonfire-slideout-active');
		},650);
		jQuery('.bonfire-slideout').removeClass('bonfire-slideout-active-translate');

		return false;

	}
});
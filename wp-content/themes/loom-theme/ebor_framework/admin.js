jQuery(document).ready(function($) {
	
$('.icon-selector').each(function(){
	var $this = $(this),
		icon = $(':selected', this).attr('data-icon');
		
	$this.prev().html(' ').html('<i class="'+ icon +'"></i>');
});

$('body').on('change', '.icon-selector', function(){
	var $this = $(this),
		icon = $(':selected', this).attr('data-icon');
		
	$this.prev().html(' ').html('<i class="'+ icon +'"></i>');
});

$( "ul.blocks" ).bind( "sortstop", function(event, ui) {
	
	//if moving column inside column, cancel it
	if(ui.item.hasClass('block-container')) {
		$parent = ui.item.parent()
		if( $parent.hasClass('block-container') || $parent.hasClass("column-blocks") ) { 
			$(this).sortable('cancel');
			return false;
		}
	}

});

$('li').has('a.column-close').css({
	'height' : '20px',
	'overflow' : 'hidden'
});

$('.column-close').click(function(){
	if( $(this).parents('li').height() > 20 ){
		$(this).parents('li').css({
			'height' : '20px',
			'overflow' : 'hidden'
		});
	} else {
		$(this).parents('li').css({
			'height' : 'auto',
			'overflow' : 'hidden'
		});
	}
	return false;
});


function show_boxes(){

	//POST FORMAT GALLERY METABOXES
	if ( $('input#post-format-gallery').is(':checked') || $('input#post-format-image').is(':checked') ) {
		$('#gallery_metabox').show();
	}
	else {
		$('#gallery_metabox').hide();
	}
	
	
	//POST FORMAT LINK METABOXES
	if ( $('input#post-format-link').is(':checked') ) {
		$('#link_metabox').show();
	}
	else {
		$('#link_metabox').hide();
	}
	
	
	//POST FORMAT QUOTE METABOXES
	if ( $('input#post-format-quote').is(':checked') ) {
		$('#quote_metabox').show();
	}
	else {
		$('#quote_metabox').hide();
	}
	
	
	//POST FORMAT VIDEO METABOXES
	if ( $('input#post-format-video').is(':checked') || $('input#post-format-audio').is(':checked') ) {
		$('#video_metabox').show();
	}
	else {
		$('#video_metabox').hide();
	}
	
	
	//POST FORMAT ASIDE METABOXES
	if ( $('input#post-format-aside').is(':checked') ) {
		$('#aside_metabox').show();
	}
	else {
		$('#aside_metabox').hide();
	}
	
	
	//POST FORMAT STATUS METABOXES
	if ( $('input#post-format-status').is(':checked') ) {
		$('#status_metabox').show();
	}
	else {
		$('#status_metabox').hide();
	}
	
	
	//POST FORMAT CHAT METABOXES
	if ( $('input#post-format-chat').is(':checked') ) {
		$('#chat_metabox').show();
	}
	else {
		$('#chat_metabox').hide();
	}
	
	
	//CONTACT PAGE METABOXES
	if ( $('select#page_template :selected').val() == 'page_contact.php' ) {
		$('#contact_metabox').show();
	}
	else {
		$('#contact_metabox').hide();
	}
	
	
	//CONTACT PAGE METABOXES
	if ( $('select#page_template :selected').val() == 'page-about.php' ) {
		$('#about_metabox').show();
	}
	else {
		$('#about_metabox').hide();
	}
	
	
	//HOME PAGE METABOXES
	if ( $('select#page_template :selected').val() == 'page-home.php' ) {
		$('#home_metabox').show();
	}
	else {
		$('#home_metabox').hide();
	}
	
	//PORTFOLIO PAGE METABOXES
	if ( $('select#page_template :selected').val() == 'page-portfolio-1column.php' ) {
		$('#portfolio_pages_metabox').show();
	} 
	else {
		$('#portfolio_pages_metabox').hide();
	}
};

//CALL SHOW_BOXES
show_boxes();

//CALL SHOW_BOXES AGAIN ON INPUT CLICK
$('input').click(function(){
	show_boxes();
});

$('select#page_template').change(function(){
	show_boxes();
});
	
});
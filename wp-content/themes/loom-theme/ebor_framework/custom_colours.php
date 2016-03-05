<?php 
	add_action('wp_head','ebor_custom_colours', 20);
	function ebor_custom_colours(){
		
		$highlight = get_option('highlight_colour','#1abb9c');
		$highlightrgb = ebor_hex2rgb( $highlight );
		$highlight_hover = get_option('highlight_hover_colour','#17a78b');
		$dark_wrapper = get_option('wrapper_background_dark', '#f5f5f5');
		$header_bg = get_option('header_bg', '#f5f5f5');
		$header_dropdown_bg = get_option('header_dropdown_bg', '#414141');
		$footer_bg = get_option('footer_bg', '#303030');
		$sub_footer_bg = get_option('sub_footer_bg', '#2d2d2d');
?>
	
<style type="text/css">
	
	/**
	 * Header
	 */
	.navbar-header {
		background: <?php echo $header_bg; ?>;
		border-top: 3px solid <?php echo $header_dropdown_bg; ?>;
	}
	
	.navbar.basic.fixed .navbar-header {
		background: rgba(<?php echo ebor_hex2rgb($header_bg); ?>,0.94);
	}
	
	.navbar .dropdown-menu {
		background: <?php echo $header_dropdown_bg; ?>;
	}
	
	/**
	 * Footer
	 */
	.footer {
		background: <?php echo $footer_bg; ?>;
	}
	
	.sub-footer {
		background: <?php echo $sub_footer_bg; ?>;
	}
	
	/**
	 * Page Wrappers Backgounds
	 */
	.light-wrapper,
	#sub-header.sub-footer.social-light {
	    background: #<?php echo get_background_color(); ?>;
	}
	.dark-wrapper,
	#sub-header.sub-footer.social-line {
	    background: <?php echo $dark_wrapper; ?>;
	}
	<?php if( get_background_image() ) : ?>
		.light-wrapper {
		    background: none;
		}
	<?php endif; ?>
	
	/**
	 * Highlight Colours
	 */
	.spinner,
	.tp-loader,
	#fancybox-loading div {
	    border-left: 3px solid rgba(<?php echo $highlightrgb; ?>,.15) !important;
	    border-right: 3px solid rgba(<?php echo $highlightrgb; ?>,.15) !important;
	    border-bottom: 3px solid rgba(<?php echo $highlightrgb; ?>,.15) !important;
	    border-top: 3px solid rgba(<?php echo $highlightrgb; ?>,.8) !important;
	}
	a,
	.colored,
	.post-title a:hover,
	ul.circled li:before,
	.lead.lite a:hover,
	.footer a:hover,
	.nav > li > a:hover,
	.nav > li.current > a,
	.navbar .nav .open > a,
	.navbar .nav .open > a:hover,
	.navbar .nav .open > a:focus,
	.navbar .dropdown-menu > li > a:hover,
	.navbar .dropdown-menu > li > a:focus,
	.navbar .dropdown-submenu:hover > a,
	.navbar .dropdown-submenu:focus > a,
	.navbar .dropdown-menu > .active > a,
	.navbar .dropdown-menu > .active > a:hover,
	.navbar .dropdown-menu > .active > a:focus,
	.filter li a:hover,
	.filter li a.active,
	ul.circled li:before, 
	.widget_categories ul li:before,
	.post-content ul li:before,
	.textwidget a,
	#sub-header .pull-left i,
	#sub-header.sub-footer.social-line .pull-left a:hover,
	#sub-header.sub-footer.social-light .pull-left a:hover,
	#menu-standard-navigation a.active  {
	    color: <?php echo $highlight; ?>;
	}
	.lead.lite a {
	    border-bottom: 1px solid <?php echo $highlight; ?>;
	}
	.btn,
	.parallax .btn-submit,
	.btn-submit,
	.newsletter-wrapper #mc_embed_signup .button,
	.widget_ns_mailchimp form input[type="submit"],
	input[type="submit"],
	.bonfire-slideout-content input[type="submit"],
	input[type="button"] {
	    background: <?php echo $highlight; ?>;
	}
	.btn:hover,
	.btn:focus,
	.btn:active,
	.btn.active,
	.parallax .btn-submit:hover,
	input[type="submit"]:hover,
	.bonfire-slideout-content input[type="submit"]:hover,
	.widget_ns_mailchimp form input[type="submit"]:hover,
	input[type="button"] {
	    background: <?php echo $highlight_hover; ?>;
	}
	.tooltip-inner {
	    background-color: <?php echo $highlight; ?>;
	}
	.tooltip.top .tooltip-arrow,
	.tooltip.top-left .tooltip-arrow,
	.tooltip.top-right .tooltip-arrow {
	    border-top-color: <?php echo $highlight; ?>
	}
	.tooltip.right .tooltip-arrow {
	    border-right-color: <?php echo $highlight; ?>
	}
	.tooltip.left .tooltip-arrow {
	    border-left-color: <?php echo $highlight; ?>
	}
	.tooltip.bottom .tooltip-arrow,
	.tooltip.bottom-left .tooltip-arrow,
	.tooltip.bottom-right .tooltip-arrow {
	    border-bottom-color: <?php echo $highlight; ?>
	}
	.services-1 .col-wrapper:hover,
	.services-1 .col-wrapper:hover:before {
	    border-color: <?php echo $highlight; ?>
	}
	.services-3 .icon i.icn {
	    color: <?php echo $highlight; ?>;
	    border: 2px solid <?php echo $highlight; ?>;
	}
	.services-3 .col:hover i.icn {
	    background-color: <?php echo $highlight; ?>;
	}
	.panel-title > a:hover {
	    color: <?php echo $highlight; ?>
	}
	.progress-list li em {
	    color: <?php echo $highlight; ?>;
	}
	.progress.plain {
	    border: 1px solid <?php echo $highlight; ?>;
	}
	.progress.plain .bar {
	    background: <?php echo $highlight; ?>;
	}
	.meta.tags a:hover {
	    color: <?php echo $highlight; ?>
	}
	.owl-carousel .owl-controls .owl-prev:hover,
	.owl-carousel .owl-controls .owl-next:hover {
	    border: 1px solid <?php echo $highlight; ?>;
	    color: <?php echo $highlight; ?>;
	}
	.navigation a:hover {
	    border: 1px solid <?php echo $highlight; ?>;
	    color: <?php echo $highlight; ?>;
	}
	.tp-caption a,
	#testimonials .author,
	.tabs-top .tab a:hover,
	.tabs-top .tab.active a {
	    color: <?php echo $highlight; ?>
	}
	.parallax a:hover {
	    color: <?php echo $highlight_hover; ?>
	}
	.pagination ul > li > a:hover,
	.pagination ul > li > a:focus,
	.pagination ul > .active > a,
	.pagination ul > .active > span {
	    border: 1px solid <?php echo $highlight; ?>;
	    color: <?php echo $highlight; ?>;
	}
	.sidebox a:hover {
	    color: <?php echo $highlight; ?>
	}
	#comments .info h2 a:hover {
	    color: <?php echo $highlight; ?>
	}
	#comments a.reply-link:hover {
	    color: <?php echo $highlight; ?>
	}
	.pricing .plan h4 span {
	    color: <?php echo $highlight; ?>
	}
	.bonfire-slideout-button:hover {
		color: <?php echo $highlight; ?>;
	}
	.bonfire-slideout-close:hover {
		color: <?php echo $highlight; ?>;
	}
	.bonfire-slideout-content .btn-submit {
	    background: <?php echo $highlight; ?>
	}
	@media (max-width: 991px) { 
		.navbar-nav > li > a,
		.navbar-nav > li > a:focus {
		    color: <?php echo $highlight; ?>
		}
	}
	
	<?php
		echo get_option('custom_css'); 
	?>
	
</style>
	
<?php }

add_action('login_head','ebor_custom_admin');
function ebor_custom_admin(){
	if( get_option('custom_login_logo') )
		echo '<style type="text/css">
				.login h1 a { 
					background-image: url("'.get_option('custom_login_logo').'"); 
					background-size: auto 80px;
					width: 100%; 
				} 
			</style>';
}
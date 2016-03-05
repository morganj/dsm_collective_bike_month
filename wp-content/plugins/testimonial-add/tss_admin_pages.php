<?php


add_action('admin_menu','tss_admin_menupage');
function tss_admin_menupage(){

	add_menu_page( 'Testimonials', "Testimonials",'administrator', 'tss_slider','TssFrontpageUI','dashicons-admin-plugins');
	add_submenu_page( 'tss_slider', 'Testimonial Settings', 'Settings', 'administrator', 'administrator', 'Tss_Settings' );
}
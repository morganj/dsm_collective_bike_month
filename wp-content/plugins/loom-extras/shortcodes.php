<?php 

function ebor_tooltip( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'location' => 'top',
		'title' => 'Tooltip on top',
		'link' => '#'
	), $atts));	
	
	return '<a href="#" title="'. $title .'" data-rel="tooltip" data-placement="' . $location . '">' . $content . '</a>';
}
add_shortcode('tooltip', 'ebor_tooltip');

//Button [button link='google.com' size='large' color='blue' target='blank']Link Text[/button]
function seabird_button( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'link' => '',
		'size' => '',
		'color' => 'blue',
		'target' => ''
	), $atts));
	if($size == 'large') $size = 'btn-large';
	if($target == 'blank') $target = 'target="_blank"';
    return '<a href="' . esc_url($link) . '" '.$target.' class="btn '.$size.' btn-'.$color.'">' . $content . '</a>';
}
add_shortcode('button', 'seabird_button');

//DROPCAP [dropcap]Content[/dropcap]
function seabird_dropcap( $atts, $content = null ) {
   return '<span class="dropcap">' . do_shortcode($content) . '</span>';
}
add_shortcode('dropcap', 'seabird_dropcap');

//BLOCKQUOTE [blockquote author='John Doe']Content[/blockquote]
function seabird_blockquote( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'author' => ''
	), $atts));
   return '<blockquote>' . do_shortcode($content) . '<small>'.$author.'</small></blockquote>';
}
add_shortcode('blockquote', 'seabird_blockquote');

//BREAK [break]
function seabird_break( $atts, $content = null ) {
   return '<div style="width: 100%; clear: both; height: 40px;"></div><hr /><div style="width: 100%; clear: both; height: 60px;"></div>';
}
add_shortcode('break', 'seabird_break');

//CLEAR [clear]
function seabird_clear( $atts, $content = null ) {
   return '<div class="divide20"></div>';
}
add_shortcode('clear', 'seabird_clear');

//HIGHLIGHT [highlight]Content[/highlight]
function seabird_highlight( $atts, $content = null ) {
   return '<span class="lite">' . do_shortcode($content) . '</span>';
}
add_shortcode('highlight', 'seabird_highlight');

//ONE HALF
function montreal_one_half( $atts, $content = null ) {
   return '<div class="col-sm-6">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_half', 'montreal_one_half');

//ONE THIRD
function montreal_one_third( $atts, $content = null ) {
   return '<div class="col-sm-4">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_third', 'montreal_one_third');

//ONE QUARTER
function montreal_one_quarter( $atts, $content = null ) {
   return '<div class="col-sm-3">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_quarter', 'montreal_one_quarter');

//THREE QUARTERS
function montreal_three_quarters( $atts, $content = null ) {
   return '<div class="col-sm-9">' . do_shortcode($content) . '</div>';
}
add_shortcode('three_quarters', 'montreal_three_quarters');

//TWO THIRDS
function montreal_two_thirds( $atts, $content = null ) {
   return '<div class="col-sm-8">' . do_shortcode($content) . '</div>';
}
add_shortcode('two_thirds', 'montreal_two_thirds');
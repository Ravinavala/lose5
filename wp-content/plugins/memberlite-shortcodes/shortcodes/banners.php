<?php
function memberlitesc_banner_shortcode($atts, $content = null) {
	// $atts    ::= array of attributes
	// $content ::= text within enclosing form of shortcode element
	// examples: [memberlite_banner align="center" background="primary" color="#FFFFFF" title="Banner Title"]
    extract(shortcode_atts(array(
		'align' => '',
		'background' => 'primary',
		'color' => '',
		'title' => '',
    ), $atts));
	if(preg_match('/^#[a-f0-9]{6}$/i', $background)) 
		$r = '<div class="banner" style="background-color: ' . $background . '">';
	elseif(preg_match('/^[a-f0-9]{6}$/i', $background))
		$r = '<div class="banner" style="background-color: #' . $background . '">';
	else
		$r = '<div class="banner banner_' . $background . '">';
	$r .= '<div class="row"><div class="medium-12 columns';
	if($align)
		$r .= ' text-' . $align;
	$r .= '"';
	if(preg_match('/^#[a-f0-9]{6}$/i', $color)) 
		$r .= ' style="color: ' . $color . '"';
	elseif(preg_match('/^[a-f0-9]{6}$/i', $color))
		$r .= ' style="color: #' . $color . '"';
	$r .= '>';
	if(!empty($title))
		$r .= '<h2>' . $title . '</h2>';
    $r .= apply_filters('the_content', $content);
    $r .= '</div></div></div>';
    return $r;
}
remove_shortcode('memberlite_banner');	//replace shortcode bundled with Memberlite 2.0 and prior or anywhere else
add_shortcode('memberlite_banner', 'memberlitesc_banner_shortcode');

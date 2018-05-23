<?php
function memberlitesc_fa_shortcode($atts, $content = null) {
	// $atts    ::= array of attributes
	// $content ::= text within enclosing form of shortcode element
	// examples: [fa icon="comment" color="primary" size="3x"]

    extract(shortcode_atts(array(
		'color' => '',
		'icon' => '',
		'size' => '',
    ), $atts));
    $r = '<i class="fa fa-' . $icon;
	if(!empty($color))
	{
		$r .= ' ' . $color;
	}
	if(!empty($size))
	{
		$r .= ' fa-' . $size;
	}
	$r .= '"></i>';
    return $r;
}
remove_shortcode('fa');	//replace shortcode bundled with Memberlite 2.0 and prior or anywhere else
add_shortcode('fa', 'memberlitesc_fa_shortcode');

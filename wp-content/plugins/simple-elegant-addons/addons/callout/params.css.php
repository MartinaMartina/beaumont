<?php
$params['title_font_size'] = array(
	'selector' => '.callout-title',
	'property' => 'font-size',
	'default' => '',
);
$params['title_font_weight'] = array(
	'selector' => '.callout-title',
	'property' => 'font-weight',
	'default' => '',
);
$params['title_text_transform'] = array(
	'selector' => '.callout-title',
	'property' => 'text-transform',
	'default' => '',
);
$params['title_letter_spacing'] = array(
	'selector' => '.callout-title',
	'property' => 'letter-spacing',
	'default' => '',
);
$params['padding_left'] = array(
	 array(
		'selector' => '.wi-btn',
		'property' => 'padding-left',
		'unit' => 'px',
	 ),
	 array(
		'selector' => '.wi-btn',
		'property' => 'padding-right',
		'unit' => 'px',
	 ),
	'default' => '',
);$params['padding_top'] = array(
	 array(
		'selector' => '.wi-btn',
		'property' => 'padding-top',
		'unit' => 'px',
	 ),
	 array(
		'selector' => '.wi-btn',
		'property' => 'padding-bottom',
		'unit' => 'px',
	 ),
	'default' => '',
);$params['border_radius'] = array(
	'selector' => '.wi-btn',
	'property' => 'border-radius',
	'unit' => 'px',
	'default' => '',
);
$params['font_size'] = array(
	'selector' => '.wi-btn',
	'property' => 'font-size',
	'unit' => 'px',
	'default' => '',
);
$params['font_weight'] = array(
	'selector' => '.wi-btn',
	'property' => 'font-weight',
	'default' => '',
);
$params['text_transform'] = array(
	'selector' => '.wi-btn',
	'property' => 'text-transform',
	'default' => '',
);
$params['letter_spacing'] = array(
	'selector' => '.wi-btn',
	'property' => 'letter-spacing',
	'default' => '',
);
$params['border_width'] = array(
	'selector' => '.wi-btn',
	'property' => 'border-width',
	'default' => '',
	'dependency' => array(
		'element' => 'style',
		'value' => array( 'outline',  'fill',  'custom', )
	),
);
$params['color'] = array(
	'selector' => '.wi-btn',
	'property' => 'color',
	'default' => '',
	'dependency' => array(
		'element' => 'style',
		'value' => array( 'custom',  'outline',  'fill', )
	),
);
$params['background'] = array(
	'selector' => '.wi-btn',
	'property' => 'background-color',
	'default' => '',
	'dependency' => array(
		'element' => 'style',
		'value' => 'custom',
	),
);
$params['border_color'] = array(
	'selector' => '.wi-btn',
	'property' => 'border-color',
	'default' => '',
	'dependency' => array(
		'element' => 'style',
		'value' => array( 'outline',  'fill', )
	),
);
$params['hover_color'] = array(
	'selector' => '.wi-btn:hover',
	'property' => 'color',
	'default' => '',
	'dependency' => array(
		'element' => 'style',
		'value' => array( 'custom',  'outline',  'fill', )
	),
);
$params['hover_background'] = array(
	'selector' => '.wi-btn:hover',
	'property' => 'background-color',
	'default' => '',
	'dependency' => array(
		'element' => 'style',
		'value' => array( 'custom',  'fill', )
	),
);
$params['hover_border'] = array(
	'selector' => '.wi-btn:hover',
	'property' => 'border-color',
	'default' => '',
	'dependency' => array(
		'element' => 'style',
		'value' => array( 'outline',  'custom', )
	),
);

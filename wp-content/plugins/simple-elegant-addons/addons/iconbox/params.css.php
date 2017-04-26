<?php
$params['icon_size'] = array(
	 array(
		'selector' => '.icon',
		'property' => 'width',
	 ),
	 array(
		'selector' => '.icon',
		'property' => 'height',
	 ),
	 array(
		'selector' => '.icon',
		'property' => 'line-height',
		'unit' => 'px',
	 ),
	'default' => '',
);$params['icon_font_size'] = array(
	'selector' => '.icon',
	'property' => 'font-size',
	'default' => '',
	'dependency' => array(
		'element' => 'icon_type',
		'value' => array( 'icon',  'thin_icon', )
	),
);
$params['icon_normal_color'] = array(
	'selector' => '.icon-inner',
	'property' => 'color',
	'default' => '',
	'dependency' => array(
		'element' => 'icon_type',
		'value' => array( 'icon',  'thin_icon', )
	),
);
$params['icon_normal_background'] = array(
	'selector' => '.icon-inner',
	'property' => 'background-color',
	'default' => '',
	'dependency' => array(
		'element' => 'icon_type',
		'value' => array( 'icon',  'thin_icon', )
	),
);
$params['icon_color'] = array(
	'selector' => '.wi-iconbox:hover .icon-inner',
	'property' => 'color',
	'default' => '',
	'dependency' => array(
		'element' => 'icon_type',
		'value' => array( 'icon',  'thin_icon', )
	),
);
$params['icon_background'] = array(
	'selector' => '.wi-iconbox:hover .icon-inner',
	'property' => 'background-color',
	'default' => '',
	'dependency' => array(
		'element' => 'icon_type',
		'value' => array( 'icon',  'thin_icon', )
	),
);
$params['title_color'] = array(
	'selector' => '.iconbox-title',
	'property' => 'color',
	'default' => '',
);
$params['title_font_size'] = array(
	'selector' => '.iconbox-title',
	'property' => 'font-size',
	'default' => '',
);
$params['title_text_transform'] = array(
	'selector' => '.iconbox-title',
	'property' => 'text-transform',
	'default' => '',
);
$params['title_letter_spacing'] = array(
	'selector' => '.iconbox-title',
	'property' => 'letter-spacing',
	'default' => '',
);
$params['title_font_weight'] = array(
	'selector' => '.iconbox-title',
	'property' => 'font-weight',
	'default' => '',
);
$params['title_font_style'] = array(
	'selector' => '.iconbox-title',
	'property' => 'font-style',
	'default' => '',
);
$params['content_font_size'] = array(
	'selector' => '.iconbox-desc',
	'property' => 'font-size',
	'default' => '',
);
$params['content_color'] = array(
	'selector' => '.iconbox-desc',
	'property' => 'color',
	'default' => '',
);

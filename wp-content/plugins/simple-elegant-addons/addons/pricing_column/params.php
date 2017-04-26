<?php

$params[] = array(
    'type' => 'textfield',
    'heading' => 'Title',
    'param_name' => 'title',
    'value' => 'Basic Plan',
    'admin_label' => true,
);

$params[] = array(
    'type' => 'textfield',
    'heading' => 'Price',
    'param_name' => 'price',
    'value' => '49',
);

$params[] = array(
    'type' => 'textfield',
    'heading' => 'Price Unit',
    'param_name' => 'price_unit',
    'value' => '$',
);

$params[] = array(
    'type' => 'textfield',
    'heading' => 'Per',
    'param_name' => 'per',
    'value' => 'per month',
);

$params[] = array(
    'type' => 'textarea_html',
    'heading' => 'Features',
    'param_name' => 'content',
    'value' => '<ul><li><strong>01</strong> Websites</li><li><strong>05</strong> Emails</li><li><strong>06</strong> Months support</li><li><strong>Unlimited</strong> Storage</li></ul>'
);

// BUTTON
//

$params = array_merge( $params, withemes_button_params( 'Button' ) );
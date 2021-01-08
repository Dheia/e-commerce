<?php return [
    'plugin'     => [
        'name'        => 'Subscriptions for Shopaholic',
        'description' => 'Lets you sell subscriptions',
    ],
    'menu'       => [
        'period'             => 'Access period to subscriptions',
        'period_description' => '',
        'access'             => 'User access to subscriptions',
    ],
    'tab'        => [
        'subscription' => 'Subscriptions',
    ],
    'field'      => [
        'is_subscription'          => 'Is subscription',
        'period'                   => 'Period',
        'period_access'            => 'Access period to subscription',
        'period_description'       => 'You can set relative intervals with using syntax: <strong>15 min, 2 hour, 10 day, 3 month, 1 year</strong>',
        'unlimited_period'         => 'Unlimited',
        'expire_at'                => 'Access expire at',
        'order_status'             => 'Order status',
        'order_status_description' => 'Select order status at which access to subscription will be created',
        'expire_type'              => 'Calculation logic of expiration date for access to subscriptions',
    ],
    'period'     => [
        'name'       => 'period',
        'list_title' => 'Period list',
    ],
    'access'     => [
        'name'       => 'access',
        'list_title' => 'Access list',
    ],
    'permission' => [
        'period' => 'Management access period to subscriptions',
        'access' => 'Management user access to subscriptions',
    ],
    'type'       => [
        'right_now'    => 'Right now',
        'begin_of_day' => 'Beginning of day',
        'end_of_day'   => 'End of day',
    ],
];
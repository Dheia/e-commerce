<?php return [
    'plugin'     => [
        'name'        => 'Reviews for Shopaholic',
        'description' => 'Reviews for the products of the catalog',
    ],
    'field'      => [
        'user_name'         => 'User name',
        'rating'            => 'Rating',
        'product'           => 'Product',
        'comment'           => 'Comment',
        'reviews'           => 'Reviews',
        'rating_from'       => 'Min value of rating',
        'rating_to'         => 'Max value of rating',
        'review_activation' => 'Automatically activate review after creating',
    ],
    'review'     => [
        'name'       => 'review',
        'list_title' => 'Review list',
    ],
    'tab'        => [
        'review_settings' => 'Reviews',
    ],
    'menu'       => [
        'reviews' => 'Reviews',
    ],
    'component'  => [
        'make_review_name'        => 'Create review',
        'make_review_description' => 'Form to create a new review',
    ],
    'message'    => [
        'e_product_id_field' => 'Product ID field is corrupt',
    ],
    'permission' => [
        'review' => 'Manage reviews',
    ],
];